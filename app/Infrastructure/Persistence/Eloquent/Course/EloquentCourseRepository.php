<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Course;

use App\Infrastructure\Persistence\Repository\CourseRepositoryInterface;
use App\Models\LMS\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentCourseRepository implements CourseRepositoryInterface
{
    public function findById(int $id): ?Course
    {
        return Course::find($id);
    }

    public function save(array $data): Course
    {
        return Course::create($data);
    }

    public function update(Course $course, array $data): Course
    {
        $course->update($data);

        return $course;
    }

    public function paginate(int $perPage, string $search): LengthAwarePaginator
    {
        $query = Course::query()
            ->select([
                'id',
                'image',
                'title',
                'created_at'
            ])
            ->with('image')
            ->orderByDesc('id');

        if ($search !== '') {
            $query->where('title', 'like', "%{$search}%");
        }

        return $query->paginate($perPage);
    }
}
