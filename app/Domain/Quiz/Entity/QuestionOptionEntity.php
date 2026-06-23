<?php
declare(strict_types=1);

namespace App\Domain\Quiz\Entity;

use App\Domain\Quiz\ValueObject\MediaValueObject;
use App\Domain\Quiz\ValueObject\SettingsValueObject;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class QuestionOptionEntity
{
    public function __construct(
        private readonly int $id,
        private readonly Uuid $uuid,
        private ?string $text = null,
        private ?Uuid $matchKey = null,
        private ?int $orderIndex = null,

        /** @var MediaValueObject[] */
        private ?array $media = null,
        private ?SettingsValueObject $settings = null,
        private readonly DateTimeImmutable $createdAt,
        private ?DateTimeImmutable $updatedAt = null,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getMatchKey(): ?Uuid
    {
        return $this->matchKey;
    }

    public function setMatchKey(?Uuid $matchKey): self
    {
        $this->matchKey = $matchKey;
        return $this;
    }

    public function getOrderIndex(): ?int
    {
        return $this->orderIndex;
    }

    public function getMedia(): ?array
    {
        return $this->media;
    }

    public function getSettings(): ?SettingsValueObject
    {
        return $this->settings;
    }

    public function setSettings(?SettingsValueObject $settings): self
    {
        $this->settings = $settings;
        return $this;
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
