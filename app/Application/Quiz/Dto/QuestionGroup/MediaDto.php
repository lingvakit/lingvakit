<?php

declare(strict_types=1);

namespace App\Application\Quiz\Dto\QuestionGroup;

use App\Application\Quiz\Enum\MediaType;

readonly class MediaDto
{
    public function __construct(
        private MediaType $type,
        private int $mediaId,
        private ?string $alt = null,
    ) {}

    public function getType(): MediaType
    {
        return $this->type;
    }

    public function getMediaId(): int
    {
        return $this->mediaId;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }
}