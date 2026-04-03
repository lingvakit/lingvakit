<?php
declare(strict_types=1);

namespace App\Application\Course\Dto\Lesson;

class LessonDetailsDto
{
    public function __construct(
        public int $id,
        public string $title,
        public ?string $description = null,
        public ?string $imageUrl = null,
        public ?string $audioUrl = null,
        public ?string $videoUrl = null,
        public int $duration,
        public ?int $orderIndex = null,
    ) {}
}
