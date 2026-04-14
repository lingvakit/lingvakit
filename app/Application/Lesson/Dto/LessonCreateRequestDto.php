<?php
declare(strict_types=1);

namespace App\Application\Lesson\Dto;

use App\Application\Topic\Enum\TopicTypeEnum;

final readonly class LessonCreateRequestDto
{
    public function __construct(
        public int $moduleId,
        public string $title,
        public int $duration,
        public ?string $description = null,
        public ?int $imageMediaId = null,
        public ?int $audioMediaId = null,
        public ?int $videoMediaId = null,
        public ?int $orderIndex = null,
    ) {
    }

    public function convertToArray(int $topicId): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->imageMediaId,
            'audio' => $this->audioMediaId,
            'video' => $this->videoMediaId,
            'duration' => $this->duration,
            'topic_id' => $topicId
        ];
    }

    public function convertToArrayForTopic(): array
    {
        return [
            'index_number' => $this->orderIndex,
            'name' => TopicTypeEnum::Lesson->value,
            'stage_id' => $this->moduleId,
            'passed_topics' => null
        ];
    }
}
