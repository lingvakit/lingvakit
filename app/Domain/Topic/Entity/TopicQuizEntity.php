<?php
declare (strict_types=1);

namespace App\Domain\Topic\Entity;

use App\Domain\Topic\Enum\TopicTypeEnum;
use DateTimeImmutable;

class TopicQuizEntity
{
    public function __construct(
        private readonly int $id,
        private ?string $entityId = null,
        private ?int $orderIndex = null,
        private TopicTypeEnum $type,
        private int $moduleId,
        private ?string $passedTopics = null,
        private TopicQuizEntity $quiz,
        private readonly ?DateTimeImmutable $createdAt = null,
        private ?DateTimeImmutable $updatedAt = null,
        private ?DateTimeImmutable $deletedAt = null,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEntityId(): ?string
    {
        return $this->entityId;
    }

    public function setEntityId(?string $entityId): TopicQuizEntity
    {
        $this->entityId = $entityId;
        $this->updatedAt = new DateTimeImmutable();

        return $this;
    }

    public function getOrderIndex(): ?int
    {
        return $this->orderIndex;
    }

    public function getType(): TopicTypeEnum
    {
        return $this->type;
    }

    public function getModuleId(): int
    {
        return $this->moduleId;
    }

    public function getPassedTopics(): ?string
    {
        return $this->passedTopics;
    }

    public function getQuiz(): ?TopicQuizEntity
    {
        return $this->quiz;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
