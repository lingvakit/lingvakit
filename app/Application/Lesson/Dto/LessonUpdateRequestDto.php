<?php
declare(strict_types=1);

namespace App\Application\Lesson\Dto;

class LessonUpdateRequestDto
{
    public function __construct(
        public ?int $moduleId = null,
        public ?string $title,
        public ?int $duration,
        public ?string $description = null,
        public ?int $imageMediaId = null,
        public ?int $audioMediaId = null,
        public ?int $videoMediaId = null,
        public ?int $orderIndex = null,
    ) {
    }

    public function convertToArray(): array
    {
        return array_filter(
            array: [
                'title' => $this->title,
                'description' => $this->description,
                'duration' => $this->duration,
                'image' => $this->imageMediaId,
                'audio' => $this->audioMediaId,
                'video' => $this->videoMediaId,
                'index_number' => $this->orderIndex,
                'stage_id' => $this->moduleId,
                'passed_topics' => null // TODO: Set actual data
            ],
            callback: fn ($value) => $value !== null
        );
    }
}
