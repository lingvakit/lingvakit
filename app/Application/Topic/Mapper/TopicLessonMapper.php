<?php
declare(strict_types=1);

namespace App\Application\Topic\Mapper;

use App\Application\Lesson\Mapper\LessonMapper;
use App\Application\Topic\Dto\TopicDto;
use App\Domain\Topic\Enum\TopicTypeEnum;
use App\Models\LMS\Topic;

final readonly class TopicLessonMapper
{
    public function __construct(
        private LessonMapper $lessonMapper
    ) {
    }

    public function fromModel(Topic $topic): TopicDto
    {
        return new TopicDto(
            id: $topic->id,
            type: TopicTypeEnum::from($topic->name),
            orderIndex: $topic->index_number,
            lesson: $this->lessonMapper->fromModel($topic->lesson)
        );
    }
}
