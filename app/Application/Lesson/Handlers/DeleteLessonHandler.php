<?php
declare(strict_types=1);

namespace App\Application\Lesson\Handlers;

use App\Domain\Lesson\Repository\LessonRepositoryInterface;
use App\Domain\Topic\Repository\TopicRepositoryInterface;
use App\Exceptions\LessonNotExistsException;
use Illuminate\Database\DatabaseManager;

final readonly class DeleteLessonHandler implements DeleteLessonHandlerInterface
{
    public function __construct(
        private DatabaseManager $db,
        private TopicRepositoryInterface $topicRepository,
        private LessonRepositoryInterface $lessonRepository,
    ) {
    }

    public function handle(int $lessonId): void
    {
        $this->db->transaction(function () use ($lessonId) {
            $lesson = $this->lessonRepository->findById($lessonId);

            if ($lesson === null) {
                throw new LessonNotExistsException(
                    message: "Lesson with id {$lessonId} not found"
                );
            }

            $this->lessonRepository->delete($lesson->getId());
            $this->topicRepository->delete($lesson->getTopicId());
        });
    }
}
