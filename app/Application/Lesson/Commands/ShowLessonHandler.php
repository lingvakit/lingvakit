<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

use App\Infrastructure\Persistence\Repository\LessonRepository;
use App\Models\LMS\Lesson;

final readonly class ShowLessonHandler
{
    public function __construct(
        private LessonRepository $repository,
    ) {}

    public function handle(int $lessonId): Lesson
    {
        return $this->repository->getById($lessonId);
    }
}
