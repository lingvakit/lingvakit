<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

use App\Infrastructure\Persistence\Repository\LessonRepository;

final readonly class DeleteLessonHandler
{
    public function __construct(
        private LessonRepository $repository
    ) {
    }

    public function handle(int $lessonId): void
    {
        $this->repository->delete($lessonId);
    }
}
