<?php
declare(strict_types=1);

namespace App\Domain\Lesson\Entity;

use App\Domain\Quiz\ValueObject\MediaValueObject;
use DateTimeImmutable;

class LessonEntity
{
    public function __construct(
        private readonly ?int $id = null,
        private string $title,
        private ?string $description = null,
        /** @var MediaValueObject[] */
        private ?array $media = [],
        private int $duration,
        private readonly int $topicId,
        private readonly DateTimeImmutable $createdAt,
        private ?DateTimeImmutable $updatedAt = null,
        private ?DateTimeImmutable $deletedAt = null,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return MediaValueObject[]
     */
    public function getMedia(): ?array
    {
        return $this->media;
    }

    public function unsetMedia(): self
    {
        $this->media = [];
        return $this;
    }

    public function addMedia(MediaValueObject $mediaFile): self
    {
        $this->media[] = $mediaFile;
        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getTopicId(): int
    {
        return $this->topicId;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }
}
