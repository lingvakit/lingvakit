<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

use App\Exceptions\LessonNotExistsException;
use App\Infrastructure\Persistence\Repository\LessonRepositoryInterface;
use App\Infrastructure\Persistence\Repository\TopicRepositoryInterface;
use Illuminate\Support\Facades\DB;

final readonly class DeleteLessonHandler implements DeleteLessonHandlerInterface
{
    public function __construct(
        private TopicRepositoryInterface $topicRepository,
        private LessonRepositoryInterface $lessonRepository,
    ) {
    }

    public function handle(int $lessonId): void
    {
        DB::transaction(function () use ($lessonId) {
            $lesson = $this->lessonRepository->findById($lessonId);

            if ($lesson === null) {
                throw new LessonNotExistsException(
                    message: "Lesson with id {$lessonId} not found"
                );
            }

            $this->topicRepository->delete($lesson->topic);
            $this->lessonRepository->delete($lesson);
        });
    }
}
