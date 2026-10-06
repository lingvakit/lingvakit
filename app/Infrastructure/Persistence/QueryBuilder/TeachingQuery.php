<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder;

use App\Models\LMS\Course;
use App\Models\LMS\HomeWorkResult;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

final class TeachingQuery
{
    public function studentIds(int $teacherId): QueryBuilder
    {
        return DB::table('course_user')
            ->whereIn(
                'course_id',
                Course::query()->where('author_id', $teacherId)->select('id')
            )
            ->select('user_id');
    }

    /**
     * Студенты преподавателя без персонала, по фамилии.
     * Раньше: User::all() + фильтр ролей в PHP.
     *
     * @return Builder<User>
     */
    public function students(int $teacherId): Builder
    {
        return User::query()
            ->whereIn('id', $this->studentIds($teacherId))
            ->withoutRole(['teacher', 'admin', 'superuser'])
            ->orderBy('surname');
    }

    /**
     * Преподаватели студента: авторы курсов, на которые он записан.
     *
     * @return Builder<User>
     */
    public function teachers(int $studentId): Builder
    {
        $courseIds = DB::table('course_user')->where('user_id', $studentId)->select('course_id');

        return User::query()->whereIn('id', Course::query()->whereIn('id', $courseIds)->select('author_id'));
    }

    /** @return Builder<HomeWorkResult> */
    public function homeWorks(int $teacherId): Builder
    {
        return HomeWorkResult::query()->whereIn('student_id', $this->studentIds($teacherId));
    }

    /** @return Builder<HomeWorkResult> */
    public function uncheckedHomeWorks(int $teacherId): Builder
    {
        return $this->homeWorks($teacherId)->whereNull('check_date');
    }
}
