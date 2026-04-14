<?php

namespace App\Models\LMS;

use App\Models\MediaFile;
use App\Models\MetaCourse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use URL;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lms_courses';

    protected $fillable = [
        'title', 'description', 'image', 'video', 'difficulty_level', 'author_id', 'category_id', 'type',
        'duration', 'price', 'sale_price', 'is_new', 'is_published', 'is_allowed', 'publish_date', 'language_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function meta()
    {
        return $this->hasOne(MetaCourse::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id', 'users');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user')->withPivot('progress');
    }

    public function image()
    {
        return $this->hasOne(MediaFile::class, 'id', 'image');
    }

    public function video()
    {
        return $this->hasOne(MediaFile::class, 'id', 'video');
    }

    public function reviews()
    {
        return $this->hasMany(CourseReview::class);
    }

    public function getTopics() : array
    {
        $collection = array();
        foreach ($this->stages as $stage) {
            $topics = Topic::where('stage_id', $stage->id)->get();
            foreach ($topics as $topic) {
                $collection[] = $topic;
            }
        }
        return $collection;
    }

    public function getQuizzes() : array
    {
        $quizzes = array();
        foreach ($this->getTopics() as $topic) {
            if ($topic->quiz) {
                $quizzes[] = $topic->quiz;
            }
        }
        return $quizzes;
    }

    public function getQuestions() : array
    {
        $questions = array();
        foreach ($this->getQuizzes() as $quiz) {
            foreach ($quiz->questions as $question) {
                $questions[] = $question;
            }
        }
        return $questions;
    }

    public function getConformity() : array
    {
        $conformityList = array();
        foreach ($this->getQuestions() as $question) {
            foreach ($question->conformities as $conformity) {
                $conformityList[] = $conformity;
            }
        }
        return $conformityList;
    }

    public function getImage() : string
    {
        if($this->image) {
            return $this->image()->first()->getPath();
        }
        return '/assets/cms/img/no-image.jpg';
    }

    public function getImageAlt()
    {
        if ($this->image) {
            return $this->image()->first()->alt;
        }
        return false;
    }

    public function getImageFullPath() : string
    {
        if($this->image) {
            return URL::to('/').$this->image()->first()->getPath();
        }
        return URL::to('/').'/assets/cms/img/no-image.jpg';
    }

    public function getVideo() : string
    {
        $video = $this->video;
        if($video && is_numeric($video)) {
            return $this->video()->first()->getPath();
        }
        return false;
    }

    public function isExternalVideo() : bool
    {
        $video = $this->video;
        if ($video && !is_numeric($video)) {
            return true;
        }
        return false;
    }

    public static function add($fields, $user)
    {
        $course = new static();
        $course->fill($fields);
        $course->author_id = $user->id;
        $course->duration = 0;
        if ($fields['type'] === 'free') {
            $course->price = 0;
        }
        if ($user->hasRole(['superuser', 'admin'])) {
            $course->is_allowed = 1;
        }
        $course->save();

        return $course;
    }

    public function addCategory($category)
    {
        if ($category) {
            $this->category_id = $category->id;
        } else {
            $this->category_id = Category::where('name', 'Uncategorized')->first()->id;
        }
        $this->save();
    }

    public function getAverageGrade()
    {
        $reviews = $this->reviews;
        $gradeSum = 0;

        if ($reviews->count()) {
            foreach ($reviews as $review) {
                $gradeSum = $gradeSum + $review->grade;
            }
            return round($gradeSum / $reviews->count());
        }

        return false;
    }

    public function isRatedByUser($user)
    {
        $review = CourseReview::where('user_id', $user->id)->where('course_id', $this->id)->first();

        if($review)
            return true;
        return false;
    }

    public function getImageSize()
    {
        $image = MediaFile::where('filename', $this->image)->first();
        return $image->getSize();
    }

    public function remove()
    {
        $this->delete();
    }

    public function getDuration() : string
    {
        return formatDuration($this);
    }

    public function getVideoId() : string
    {
        $videoArr = explode('/', $this->video);
        return end($videoArr);
    }

    /* Switcher for New Course */
    public function setUsual()
    {
        $this->is_new = 0;
        $this->save();
    }

    public function setNew()
    {
        $this->is_new = 1;
        $this->save();
    }

    public function switchIsNew($value)
    {
        if ($value == null) {
            return $this->setUsual();
        }
        return $this->setNew();
    }

    /* Switcher for Published Course */
    public function setDraft()
    {
        $this->is_published = 0;
        $this->save();
    }

    public function setPublished()
    {
        $this->is_published = 1;
        $this->save();
    }

    public function switchIsPublished($value)
    {
        if ($value == null) {
            return $this->setDraft();
        }
        return $this->setPublished();
    }

    public function updateProgress($user)
    {
        $totalTopics = 0;
        foreach ($this->stages as $stage) {
            $totalTopics += count($stage->topics);
        }

        $passedTopics = Result::where([
            ['user_id', $user->id],
            ['course_id', $this->id],
            ['status', 'passed'],
        ])->get();

        $progress = (count($passedTopics) * 100) / $totalTopics;
        $user->courses()->updateExistingPivot($this->id, ['progress' => round($progress)]);
    }

    public function priceFormat($price) : string
    {
        return number_format($price, 0, '.', ' ') . ' ₽';
    }

    public function getDiscount() : int
    {
        if ($this->sale_price) {
            return $this->price - $this->sale_price;
        }
        return 0;
    }

    public function getTotalPrice() : int
    {
        return $this->price - $this->getDiscount();
    }

    public function getPrice() : string
    {
        $usualPrice = $this->priceFormat($this->price);
        $salePrice = $this->priceFormat($this->sale_price);

        if ($this->type === 'paid') {
            if ($this->sale_price) {
                return '<span style="text-decoration: line-through">'
                            .$usualPrice.'</span> <span class="text-danger">'.$salePrice.'</span>';
            }
            return $usualPrice;
        }
        return __("site-pages.free");
    }

    public function getCurrentPrice() : string
    {
        if ($this->type === 'paid') {
            $price = $this->priceFormat($this->price);

            if ($this->sale_price) {
                $price = $this->priceFormat($this->sale_price);
            }
            return $price;
        }
        return __("site-pages.free");
    }

    public function getProgress($user)
    {
        $studentHasCourse = $this->students->contains($user->id);
        if ($studentHasCourse) {
            return $this->students()->where('user_id', $user->id)->firstOrFail()->pivot->progress . '%';
        }
        return false;
    }

    public function isBelongsToStudent($user) : bool
    {
        if ($user) {
            if ($this->students->contains($user->id)) {
                return true;
            }
        }
        return false;
    }

    public function updateDuration()
    {
        $duration = 0;

        foreach ($this->stages as $stage) {
            foreach ($stage->topics as $topic) {
                if ($topic->lesson) {
                    $duration += $topic->lesson->duration;
                } elseif ($topic->quiz) {
                    $duration += $topic->quiz->duration;
                }
            }
        }
        $this->duration = $duration;
        $this->save();
    }

    public function getTotalPoints() : int
    {
        $points = 0;
        $conformityItems = $this->getConformity();
        foreach ($conformityItems as $conformity) {
            $points += $conformity->points;
        }
        return $points;
    }

    public function belongsToCurrentTeacher() : bool
    {
        $currentUser = Auth::user();
        if ($this->author_id === $currentUser->id) {
            return true;
        }

        return false;
    }

//    public function getPublishDateAttribute($date) : string
//    {
//        if (!$date) { return false; }
//        return Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
//    }
//
//    public function setPublishDateAttribute($date)
//    {
//        $publishDate = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
//        $this->attributes['publish_date'] = $publishDate;
//    }

    public function released() : bool
    {
        if($this->publish_date) {
//            $releaseDate = Carbon::parse(Carbon::createFromFormat('d/m/Y', $this->publish_date)->format('Y-m-d'));
            if ($this->publish_date > today()) {
                return false;
            }
        }
        return true;
    }

    // Release date display
    public function getReleaseDate() : string
    {
        $class = 'text-danger';
        if ($this->released()) {
            $class = 'text-success';
        }
        return __('Release Date: ') . '<span class="'.$class.'">'.$this->publish_date.'</span>';
    }

    // Кнопка оформления заказа
    public function getActiveButton() : string
    {
        $user = Auth::user();
        $href = route('site.course-show', $this->id);

        if ($this->released()) {
            $class = 'btn btn-brand square';
        } else {
            $class = 'btn btn-warning square';
        }

        if ($user && $this->students->contains($user->id)) {
            $text = __("site-pages.to-study");
        } else {
            if (!$user) {
                $text = __("site-pages.more-info");
            } else {
                if ($this->released()) {
                    $text = __("site-pages.buy");
                } else {
                    $text = __("site-pages.pre-order");
                }
            }
        }

        return '<a href="'.$href.'" class="'.$class.'">'.$text.'</a>';
    }

    public function getPageActiveButton()
    {
        $user = Auth::user();
        $class = 'btn btn-success';
        $text = __("site-pages.buy-course");

        if (!$this->released()) {
            $class = 'btn btn-warning';
            $text = __("site-pages.pre-order");
        }

        if (! $user || ! $this->students->contains($user->id)) {
            $btn = '<div class="text-right">';
            $btn .= '<a href="'.route('orders.checkout', $this->id).'" class="'.$class.'">';
            $btn .= $text.'</a></div>';

            return $btn;
        }
        return false;
    }
}
