<?php
declare(strict_types=1);

namespace App\Application\Lesson\Dto;

class LessonUpdateRequestDto
{
    public function __construct(
        public ?int $moduleId = null,
        public string $title,
        public int $duration,
        public ?string $description = null,
        public ?int $imageMediaId = null,
        public ?int $audioMediaId = null,
        public ?int $videoMediaId = null,
        public ?int $orderIndex = null,
    ) {
    }
}
