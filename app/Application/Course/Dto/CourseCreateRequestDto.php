<?php
declare(strict_types=1);

namespace App\Application\Course\Dto;

use App\Application\Course\Enum\CoursePaidTypeEnum;
use App\Application\Course\Enum\DifficultyLevelEnum;
use DateTimeImmutable;

final readonly class CourseCreateRequestDto
{
    public function __construct(
        public string $title,
        public ?string $description = null,
        public DifficultyLevelEnum $difficultyLevel,
        public CoursePaidTypeEnum $paidType,
        public ?float $price = 0,
        public ?float $salePrice = null,
        public ?int $duration = 0,
        public int $categoryId,
        public ?int $imageMediaId = null,
        public ?int $videoMediaId = null,
        public bool $isNew = true,
        public bool $isPublished = false,
        public ?DateTimeImmutable $publishDate = null,
        public bool $isAllowed = true,
    ) {}

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'difficulty_level' => $this->difficultyLevel->value,
            'category_id' => $this->categoryId,
            'author_id' => auth()->id() ?? 1, // TODO: Remove hardcode
            'type' => $this->paidType->value,
            'price' => $this->price,
            'sale_price' => $this->salePrice,
            'duration' => $this->duration,
            'image' => $this->imageMediaId,
            'video' => $this->videoMediaId,
            'is_new' => $this->isNew,
            'is_published' => $this->isPublished,
            'publish_date' => $this->publishDate,
            'is_allowed' => $this->isAllowed,
        ];
    }
}
