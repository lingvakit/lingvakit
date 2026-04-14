<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Models\LMS\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CourseRepositoryInterface
{
    public function findById(int $id): ?Course;
    public function save(array $data): Course;
    public function update(Course $course, array $data): Course;

    /** @return LengthAwarePaginator<Course> */
    public function paginate(int $perPage, string $search): LengthAwarePaginator;
}
