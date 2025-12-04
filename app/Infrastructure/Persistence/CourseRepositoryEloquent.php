<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Course\Repositories\CourseRepository;
use App\Models\LMS\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CourseRepositoryEloquent implements CourseRepository
{
    public function filterByField(
        string $sortBy = 'title',
        string $sortOrder = 'desc',
        int $perPage = 10,
        int $page = 1
    ): LengthAwarePaginator {
        return Course::orderBy($sortBy, $sortOrder)->paginate($perPage, ['*'], 'page', $page);
    }

    public function findById(int $id): ?Course
    {
        return Course::find($id);
    }

    public function findByIdWithModules(int $id): ?Course
    {
        return Course::with([
            'stages.topics.lesson',
            'stages.topics.quiz',
            'category',
            'language',
            'author'
        ])->find($id);
    }
}