<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Dto;

use App\Domain\Quiz\Enum\QuizStatusEnum;

class QuizUpdateRequestDto
{
    public function __construct(
        public ?int $moduleId = null,
        public ?string $title,
        public ?string $description = null,
        public ?int $imageMediaId = null,
        public ?int $audioMediaId = null,
        public ?int $videoMediaId = null,
        public ?int $timeLimit,
        public ?int $passingScore,
        public ?QuizStatusEnum $status,
        public ?int $orderIndex = null,
    ) {}

    public function convertToArray(): array
    {
        return array_filter(
            array: [
                'title' => $this->title,
                'description' => $this->description,
                'imageId' => $this->imageMediaId,
                'videoId' => $this->videoMediaId,
                'audioId' => $this->audioMediaId,
                'timeLimit' => $this->timeLimit,
                'passingScore' => $this->passingScore,
                'status' => $this->status,
            ],
            callback: fn ($value) => $value !== null
        );
    }

    public function convertToArrayForTopic(): array
    {
        return array_filter(
            array: [
                'index_number' => $this->orderIndex,
                'stage_id' => $this->moduleId,
                'passed_topics' => null
            ],
            callback: fn ($value) => $value !== null
        );
    }
}
