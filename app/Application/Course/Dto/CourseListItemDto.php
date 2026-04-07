<?php
declare(strict_types=1);

namespace App\Application\Course\Dto;

use DateTimeImmutable;

final readonly class CourseListItemDto
{
    public function __construct(
        public int $id,
        public string $title,
        public ?string $imageUrl,
        public DateTimeImmutable $createdAt,
    ) {}
}
