<?php

declare(strict_types=1);

namespace App\Domain\Course\Repositories;

use App\Models\LMS\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CourseRepository
{
    public function filterByField(
        string $sortBy = 'title',
        string $sortOrder = 'asc',
        int $perPage = 10,
        int $page = 1
    ): LengthAwarePaginator;

    public function findById(int $id): ?Course;
    public function findByIdWithModules(int $id): ?Course;
}