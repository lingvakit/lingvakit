<?php
declare(strict_types=1);

namespace App\Application\Lesson\Dto;

class LessonCreateRequestDto
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
}
