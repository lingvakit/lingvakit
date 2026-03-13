<?php
declare(strict_types=1);

namespace App\Application\Course\Dto;

use App\Application\Course\Enum\DifficultyLevelEnum;

final readonly class CreateCourseDto
{
    public function __construct(
        private string $title,
        private ?string $description = null,
        private DifficultyLevelEnum $difficultyLevel,
        private float $price,
        private ?float $salePrice = null,
        private ?int $duration = 0,
        private int $categoryId,
        private ?int $imageId = null,
        private ?int $videoId = null,
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDifficultyLevel(): DifficultyLevelEnum
    {
        return $this->difficultyLevel;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getSalePrice(): ?float
    {
        return $this->salePrice;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getImageId(): ?int
    {
        return $this->imageId;
    }

    public function getVideoId(): ?int
    {
        return $this->videoId;
    }
}
