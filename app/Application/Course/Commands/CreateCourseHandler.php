<?php
declare(strict_types=1);

namespace App\Application\Course\Commands;

use App\Application\Course\Dto\CreateCourseDto;
use App\Infrastructure\Persistence\Repository\CourseRepository;

final readonly class CreateCourseHandler
{
    public function __construct(
        private CourseRepository $repository
    ) {
    }

    public function handle(CreateCourseDto $dto, int $authorId): int
    {
        return $this->repository->create($dto, $authorId);
    }
}
