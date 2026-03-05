<?php
declare(strict_types=1);

namespace App\Application\Courses\Dto\Course;

final readonly class CourseTopicDto
{
    public function __construct(
        private int $id,
        private string $title,
        private string $type,
        private string $imageUrl,
        private ?int $sortIndex = null,
        private ?array $requiredTopics = null,
        private ?string $description = null,
        private ?int $duration = null,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getSortIndex(): ?int
    {
        return $this->sortIndex;
    }

    public function getRequiredTopics(): ?array
    {
        return $this->requiredTopics;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }
}
