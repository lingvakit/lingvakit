<?php
declare(strict_types=1);

namespace App\Application\Topic\Mapper;

use App\Application\Lesson\Mapper\LessonMapper;
use App\Application\Topic\Dto\TopicDto;
use App\Application\Topic\Enum\TopicTypeEnum;
use App\Models\LMS\Topic;

final readonly class TopicMapper
{
    public function __construct(
        private LessonMapper $lessonMapper,
    ) {
    }

    public function fromModel(Topic $topic): TopicDto
    {
        $topicDto = new TopicDto(
            id: $topic->id,
            type: TopicTypeEnum::from($topic->name),
            orderIndex: $topic->index_number,
        );

        if ($topic->name === TopicTypeEnum::Lesson->value) {
            $topicDto->lesson = $this->lessonMapper->fromModel($topic->lesson);
        }

        return $topicDto;
    }
}
