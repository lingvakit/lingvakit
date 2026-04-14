<?php
declare(strict_types=1);

namespace App\Application\Course\Dto;

use App\Application\Module\Dto\ModuleDto;
use DateTimeImmutable;

final readonly class CourseDto
{
    public function __construct(
        public int $id,
        public string $title,
        public float $price,
        public int $duration,
        public string $category,
        public DateTimeImmutable $createdAt,
        public ?string $description,
        public ?string $imageUrl,
        public ?string $author,

        /** @var array<ModuleDto> */
        public ?array $modules = [],
    ) {}
}
