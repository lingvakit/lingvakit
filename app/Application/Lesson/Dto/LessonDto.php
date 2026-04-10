<?php
declare(strict_types=1);

namespace App\Application\Lesson\Dto;

use App\Application\Media\Dto\MediaFileDto;

final readonly class LessonDto
{
    public function __construct(
        public int $id,
        public string $title,
        public int $duration,
        public ?string $description = null,
        public ?MediaFileDto $imageFile = null,
        public ?MediaFileDto $audioFile = null,
        public ?MediaFileDto $videoFile = null,
        public ?int $orderIndex = null,
    ) {
    }
}
