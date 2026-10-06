<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder;

use App\Models\LMS\Course;
use App\Models\LMS\Result;
use Illuminate\Support\Facades\DB;

final class CourseProgressQuery
{
    public function points(int $userId, int $courseId): int
    {
        return (int) Result::query()
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->sum('points');
    }

    public function rank(int $userId, Course $course): ?int
    {
        $ranked = DB::table('course_user as cu')
            ->leftJoin('results as r', function ($join): void {
                $join->on('r.user_id', '=', 'cu.user_id')->on('r.course_id', '=', 'cu.course_id');
            })
            ->where('cu.course_id', $course->getKey())
            ->where('cu.user_id', '<>', $course->author_id)
            ->groupBy('cu.user_id')
            // RANK: равные баллы дают равное место
            ->selectRaw('cu.user_id, RANK() OVER (ORDER BY COALESCE(SUM(r.points), 0) DESC) AS position');

        $position = DB::query()->fromSub($ranked, 'ranked')->where('user_id', $userId)->value('position');

        return $position === null ? null : (int) $position;
    }
}