<?php
declare(strict_types=1);

namespace App\Application\Courses\Queries;

use App\Application\Courses\Dto\CourseDetailsDto;
use App\Application\Courses\ReadModel\CourseReadRepository;

final readonly class GetCourseQuery
{
    public function __construct(
        private CourseReadRepository $repository
    ) {}

    public function handle(int $id): CourseDetailsDto
    {
        return $this->repository->getById($id);
    }
}