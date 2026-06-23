<?php
declare(strict_types=1);

namespace App\Application\Lesson\Handlers;

use App\Application\Lesson\Dto\LessonDto;
use App\Application\Lesson\Mapper\LessonMapper;
use App\Domain\Lesson\Repository\LessonRepositoryInterface;
use App\Domain\Topic\Repository\TopicRepositoryInterface;
use App\Exceptions\LessonNotExistsException;

final readonly class ShowLessonHandler implements ShowLessonHandlerInterface
{
    public function __construct(
        private LessonRepositoryInterface $lessonRepository,
        private TopicRepositoryInterface $topicRepository,
        private LessonMapper $lessonMapper
    ) {}

    public function handle(int $lessonId): LessonDto
    {
        $lesson = $this->lessonRepository->findById($lessonId);

        if ($lesson === null) {
            throw new LessonNotExistsException(
                message: "Lesson with id {$lessonId} not found"
            );
        }

        $topic = $this->topicRepository->findById($lesson->getTopicId());

        return $this->lessonMapper->fromEntity($lesson, $topic);
    }
}
