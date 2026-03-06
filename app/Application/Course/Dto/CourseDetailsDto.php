<?php
declare(strict_types=1);

namespace App\Application\Course\Dto;

use App\Application\Course\Dto\Course\CourseModuleDto;

final readonly class CourseDetailsDto
{
    public function __construct(
        private int $id,
        private string $title,
        private string $price,
        private int $duration,
        private string $createdAt,
        private ?string $description,
        private ?string $imageUrl,
        private ?string $author,

        /** @var array<CourseModuleDto> */
        private ?array $modules = [],
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function getModules(): ?array
    {
        return $this->modules;
    }
}
