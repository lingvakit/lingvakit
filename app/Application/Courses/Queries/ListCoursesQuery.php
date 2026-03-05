<?php
declare(strict_types=1);

namespace App\Application\Courses\Queries;

use App\Application\Courses\ReadModel\CourseReadRepository;
use Illuminate\Pagination\AbstractPaginator;

final readonly class ListCoursesQuery
{
    public function __construct(
        private CourseReadRepository $repository
    ) {}

    public function handle(int $perPage, string $search): AbstractPaginator
    {
        return $this->repository->paginate($perPage, $search);
    }
}
