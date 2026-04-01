<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

use App\Application\Course\Dto\LessonCreateDto;
use App\Infrastructure\Persistence\Repository\LessonRepository;

final readonly class CreateLessonHandler
{
    public function __construct(
        private LessonRepository $repository
    ) {
    }

    public function handle(int $moduleId, LessonCreateDto $dto): int
    {
        return $this->repository->create($moduleId, $dto);
    }
}
