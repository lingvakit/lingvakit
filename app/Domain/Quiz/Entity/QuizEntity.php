<?php
declare(strict_types=1);

namespace App\Domain\Quiz\Entity;

use App\Domain\Quiz\ValueObject\MediaValueObject;
use DateTimeImmutable;

class QuizEntity
{
    public function __construct(
        private readonly int $id,
        private string $title,
        private ?string $description = null,
        /** @var MediaValueObject[] */
        private ?array $media = [],
        private int $timeLimit,
        private int $passingScore,
        private int $topicId,
        private int $categoryId,
        private int $moduleId,
        private ?int $orderIndex = null,

        /** @var QuestionGroupEntity[] */
        private ?array $questionGroups = null,

        private readonly DateTimeImmutable $createdAt,
        private ?DateTimeImmutable $updatedAt = null,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return MediaValueObject[]|null
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

    public function getTimeLimit(): int
    {
        return $this->timeLimit;
    }

    public function getPassingScore(): int
    {
        return $this->passingScore;
    }

    public function getTopicId(): int
    {
        return $this->topicId;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getModuleId(): int
    {
        return $this->moduleId;
    }

    public function getOrderIndex(): ?int
    {
        return $this->orderIndex;
    }

    public function getQuestionGroups(): ?array
    {
        return $this->questionGroups;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
