<?php
declare(strict_types=1);

namespace App\Application\Course\Dto;

final readonly class CourseListItemDto
{
    public function __construct(
        private int $id,
        private string $title,
        private ?string $imageUrl,
        private string $createdAt,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}
