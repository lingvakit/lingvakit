<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

use App\Application\Course\Dto\Lesson\LessonUpdateDto;
use App\Infrastructure\Persistence\Repository\LessonRepository;

final readonly class UpdateLessonHandler
{
    public function __construct(
        private LessonRepository $repository
    ) {
    }

    public function handle(int $moduleId, LessonUpdateDto $dto): void
    {
        $this->repository->update($moduleId, $dto);
    }
}
