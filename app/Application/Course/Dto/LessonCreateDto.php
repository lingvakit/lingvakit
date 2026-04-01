<?php
declare (strict_types=1);

namespace App\Application\Course\Dto;

final class LessonCreateDto
{
    public function __construct(
        public string $title,
        public int $duration,
        public ?string $description = null,
        public ?int $imageMediaId = null,
        public ?int $audioMediaId = null,
        public ?int $videoMediaId = null,
    ) {
    }
}
