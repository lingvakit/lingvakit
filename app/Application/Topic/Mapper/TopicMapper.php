<?php
declare(strict_types=1);

namespace App\Application\Topic\Mapper;

use App\Application\Lesson\Mapper\LessonMapper;
use App\Application\Quiz\Mapper\QuizMapper;
use App\Application\Topic\Dto\TopicDto;
use App\Domain\Lesson\Entity\LessonEntity;
use App\Domain\Quiz\Entity\QuizEntity;
use App\Domain\Topic\Entity\TopicEntity;
use App\Domain\Topic\Enum\TopicTypeEnum;
use App\Integration\Quiz\Dto\Response\QuizDto;
use App\Models\LMS\Topic;
use Symfony\Component\Uid\Uuid;

readonly class TopicMapper
{
    public function __construct(
        private LessonMapper $lessonMapper,
        private QuizMapper $quizMapper,
    ) {
    }

    public function fromModel(Topic $topic): ?TopicEntity
    {
        return new TopicEntity(
            id: $topic->id,
            entityId: $topic->entity_id ? Uuid::fromString($topic->entity_id) : null,
            orderIndex: $topic->index_number,
            type: TopicTypeEnum::from($topic->name),
            moduleId: $topic->stage_id,
            passedTopics: $topic->passed_topics ? explode(',', $topic->passed_topics) : null,
        );
    }

    public function fromEntity(
        TopicEntity $topic,
        ?LessonEntity $lesson,
        ?QuizEntity $quiz
    ): TopicDto {
        if ($lesson === null && $quiz === null) {
            throw new \Exception("Lesson or Quiz entity can not be null");
        }

        return new TopicDto(
            id: $topic->getId(),
            type: $topic->getType(),
            orderIndex: $topic->getOrderIndex(),
            lesson: $lesson
                ? $this->lessonMapper->fromEntity($lesson, $topic)
                : null,
            quiz: null,
        );
    }

    public function fromMs(TopicEntity $topic, QuizDto $msQuizResponseDto): TopicDto
    {
        return new TopicDto(
            id: $topic->getId(),
            type: $topic->getType(),
            orderIndex: $topic->getOrderIndex(),
            quiz: $this->quizMapper->fromMsResponse($msQuizResponseDto),
        );
    }
}
