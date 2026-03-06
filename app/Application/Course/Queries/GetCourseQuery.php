<?php
declare(strict_types=1);

namespace App\Application\Course\Queries;

use App\Application\Course\Dto\CourseDetailsDto;
use App\Application\Course\ReadModel\CourseReadRepository;

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