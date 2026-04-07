<?php
declare(strict_types=1);

namespace App\Application\Course\Dto;

use App\Application\Course\Enum\CoursePaidTypeEnum;
use App\Application\Course\Enum\DifficultyLevelEnum;
use DateTimeImmutable;

final readonly class CourseUpdateRequestDto
{
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?DifficultyLevelEnum $difficultyLevel = null,
        public ?CoursePaidTypeEnum $paidType = null,
        public ?float $price = null,
        public ?float $salePrice = null,
        public ?int $duration = null,
        public ?int $categoryId = null,
        public ?int $imageMediaId = null,
        public ?int $videoMediaId = null,
        public ?bool $isNew = null,
        public ?bool $isPublished = null,
        public ?DateTimeImmutable $publishDate = null,
        public ?bool $isAllowed = null,
    ) {}

    public function toArray(): array
    {
        return array_filter(
            array: [
                'title' => $this->title,
                'description' => $this->description,
                'difficulty_level' => $this->difficultyLevel?->value,
                'type' => $this->paidType?->value,
                'price' => $this->price,
                'sale_price' => $this->salePrice,
                'duration' => $this->duration,
                'category_id' => $this->categoryId,
                'image' => $this->imageMediaId,
                'video' => $this->videoMediaId,
                'is_new' => $this->isNew,
                'is_published' => $this->isPublished,
                'publish_date' => $this->publishDate,
                'is_allowed' => $this->isAllowed,
            ],
            callback: fn($value) => $value !== null
        );
    }
}
