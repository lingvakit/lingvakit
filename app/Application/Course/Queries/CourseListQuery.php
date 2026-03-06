<?php
declare(strict_types=1);

namespace App\Application\Course\Queries;

use App\Application\Course\ReadModel\CourseReadRepository;
use Illuminate\Pagination\AbstractPaginator;

final readonly class CourseListQuery
{
    public function __construct(
        private CourseReadRepository $repository
    ) {}

    public function handle(int $perPage, string $search): AbstractPaginator
    {
        return $this->repository->paginate($perPage, $search);
    }
}
