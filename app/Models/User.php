<?php
declare(strict_types=1);

namespace App\Models;

use App\Kafka\Producer\BaseProducer;
use App\Models\LMS\Course;
use App\Models\LMS\CourseReview;
use App\Models\LMS\HomeWorkResult;
use App\Models\LMS\Result;
use App\Models\LMS\TopicComment;
use App\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

#[Fillable([
    'name',
    'surname',
    'patronymic',
    'email',
    'phone',
    'passport',
    'country_id',
    'state',
    'city',
    'address',
    'zip',
])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles, LegacyUserApi;

    protected $hidden = [
        'password',
        'remember_token',
        'passport'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_dealer' => 'boolean',
            'is_staff' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    // ---------- Relations ----------

    public function session(): HasOne
    {
        return $this->hasOne(Session::class);
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function latestOrder(): HasOne
    {
        return $this->hasOne(Order::class)->latestOfMany('created_at');
    }

    public function setting(): HasOne
    {
        return $this->hasOne(Setting::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_user')
            ->withPivot('progress');
    }

    public function ownCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'author_id');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_user');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TopicComment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(CourseReview::class);
    }

    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class);
    }

    public function chatsByLastMessage(): BelongsToMany
    {
        return $this->chats()
            ->withMax('messages', 'date')
            ->orderByRaw('messages_max_date DESC NULLS LAST');
    }

    // ---------- Accessors ----------
    protected function fullName(): Attribute
    {
        return Attribute::get(fn(): string => implode(' ', array_filter(
            [$this->surname, $this->name, $this->patronymic],
            static fn(?string $part): bool => filled($part),
        )));
    }

    protected function customerLabel(): Attribute
    {
        return Attribute::get(fn(): string => $this->company
            ? "{$this->full_name} [{$this->company->name}]"
            : $this->full_name);
    }

    protected function phoneDigits(): Attribute
    {
        return Attribute::get(
            fn(): string => (string)preg_replace(
                pattern: '/\D+/',
                replacement: '',
                subject: (string)$this->phone
            )
        );
    }

    // ---------- Behavior ----------
    public function setDealer(bool $value): void
    {
        $this->forceFill(['is_dealer' => $value])->save();
    }

    public function hasCourse(int|Course $course): bool
    {
        return $this->courses()
            ->whereKey($course instanceof Course ? $course->getKey() : $course)
            ->exists();
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword(app(BaseProducer::class), $token));
    }


    public function getFullName()
    {
        return trim($this->surname . ' ' . $this->name . ' ' . $this->patronymic);
    }

    public function getCustomer()
    {
        $fullName = $this->getFullName();
        if ($this->company) {
            return $fullName . ' [' . $this->company->name . ']';
        }
        return $fullName;
    }

    public function isDealer()
    {
        $this->is_dealer = 1;
        $this->save();
    }

    public function isNotDealer()
    {
        $this->is_dealer = 0;
        $this->save();
    }

    public function switchDealer($value)
    {
        if ($value == null) {
            return $this->isNotDealer();
        }
        return $this->isDealer();
    }

    public function getResultsByCourse($course)
    {
        return Result::where([
            ['user_id', $this->id],
            ['course_id', $course->id],
        ])->get();
    }

    public function getPoints($course): int
    {
        $points = 0;
        $results = $this->getResultsByCourse($course);

        foreach ($results as $result) {
            $points += $result->points;
        }
        return $points;
    }

    public function getRatingByCourse($course)
    {
        $students = $course->students->except($course->author_id);

        $arr = array();
        foreach ($students as $student) {
            $arr[$student->id] = $student->getPoints($course);
        }

        $count = 0;
        arsort($arr);

        foreach ($arr as $key => $item) {
            $count += 1;

            if ($key === $this->id) {
                return $count;
            }
        }
        return false;
    }

    public function formatPhoneNumber()
    {
        $sym = ['(', ')', '+', '-', ' '];
        return str_replace($sym, '', $this->phone);
    }



    public function getMyStudents()
    {
        $myCourses = Course::where('author_id', $this->id)->get();
        $myStudentsIds = array();

        foreach ($myCourses as $course) {
            foreach ($course->students as $student) {
                $myStudentsIds[] = $student->id;
            }
        }

        $myStudentsIds = array_unique($myStudentsIds);
        $students = User::all()->reject(function ($user) {
            return $user->hasRole(['teacher', 'admin', 'superuser']);
        })->map(function ($user) {
            return $user;
        });

        return $students->only($myStudentsIds)->sortBy("surname");
    }

    public function getMyTeachers()
    {
        $myCourses = $this->courses;
        $teacherIds = array();

        foreach ($this->courses as $course) {
            if (!in_array($course->author->id, $teacherIds)) {
                $teacherIds[] = $course->author->id;
            }
        }

        return User::whereIn('id', $teacherIds)->get();
    }

    public function ownStudents(): array
    {
        $courses = $this->ownCourses;
        $students = [];

        foreach ($courses as $course) {
            foreach ($course->students as $student) {
                $students[] = $student;
            }
        }
        return $students;
    }

    public function uncheckedHomeWorks()
    {
        $studentIds = [];
        foreach ($this->ownStudents() as $ownStudent) {
            $studentIds[] = $ownStudent->id;
        }

        return HomeWorkResult::whereIn('student_id', $studentIds)->where("check_date", null)->get();
    }

    public function allHomeWorks()
    {
        $studentIds = [];
        foreach ($this->ownStudents() as $ownStudent) {
            $studentIds[] = $ownStudent->id;
        }

        return HomeWorkResult::whereIn('student_id', $studentIds)->get();
    }

    public function chatsByDesc()
    {
        $chatIdsByMsg = array();
        $chats = array();

        foreach ($this->chats as $chat) {
            $chatIdsByMsg["chat_" . $chat->id] = $chat->messages->sortByDesc('date')->first()->date;
        }
        asort($chatIdsByMsg);

        foreach ($chatIdsByMsg as $key => $chatIdByMsg) {
            $chats[] = Chat::find(substr($key, 5));
        }
        krsort($chats);
        return $chats;
    }
}
