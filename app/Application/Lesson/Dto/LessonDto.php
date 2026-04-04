<?php
declare(strict_types=1);

namespace App\Application\Lesson\Dto;

final readonly class LessonDto
{
    public function __construct(
        public int $id,
        public string $title,
        public int $duration,
        public ?string $description = null,
        public ?string $imageUrl = null,
        public ?string $audioUrl = null,
        public ?string $videoUrl = null,
        public ?int $orderIndex = null,
    ) {
    }
}
