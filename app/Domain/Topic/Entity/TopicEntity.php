<?php
declare(strict_types=1);

namespace App\Domain\Topic\Entity;

use App\Domain\Topic\Enum\TopicTypeEnum;
use Symfony\Component\Uid\Uuid;

class TopicEntity
{
    public function __construct(
        private ?int $id = null,
        private ?Uuid $entityId = null,
        private ?int $orderIndex = null,
        private TopicTypeEnum $type,
        private int $moduleId,
        /** @var int[] */
        private ?array $passedTopics = [],
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityId(): ?Uuid
    {
        return $this->entityId;
    }

    public function setEntityId(?Uuid $entityId): self
    {
        $this->entityId = $entityId;
        return $this;
    }

    public function getOrderIndex(): ?int
    {
        return $this->orderIndex;
    }

    public function setOrderIndex(?int $orderIndex): self
    {
        $this->orderIndex = $orderIndex;
        return $this;
    }

    public function getType(): TopicTypeEnum
    {
        return $this->type;
    }

    public function getModuleId(): int
    {
        return $this->moduleId;
    }

    /**
     * @return int[]|null
     */
    public function getPassedTopics(): ?array
    {
        return $this->passedTopics;
    }

    public function setPassedTopics(?array $passedTopics): self
    {
        $this->passedTopics = $passedTopics;
        return $this;
    }
}
