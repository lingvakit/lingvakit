<?php

declare(strict_types=1);

namespace App\Application\Quiz\Dto;

use Symfony\Component\Uid\Uuid;

readonly class QuestionOptionDto
{
    public function __construct(
        private Uuid $uuid,
        private ?string $text = null,
        private ?string $matchKey = null,
        private ?int $orderIndex = null,
        private ?array $settings = null,
    ) {}

    public function getUuid(): string
    {
        return $this->uuid->toRfc4122();
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getMatchKey(): ?string
    {
        return $this->matchKey;
    }

    public function getOrderIndex(): ?int
    {
        return $this->orderIndex;
    }

    public function getSettings(): ?array
    {
        return $this->settings;
    }
}