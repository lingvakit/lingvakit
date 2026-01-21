<?php

declare(strict_types=1);

namespace App\Application\Quiz\Dto;

use App\Application\Quiz\Dto\QuestionGroup\MediaDto;
use App\Application\Quiz\Dto\QuestionGroup\MetaDto;
use App\Application\Quiz\Enum\QuestionType;

readonly class QuestionGroupDto
{
    public function __construct(
        private string $uuid,
        private string $title,
        private string $questionType,
        private ?string $description = null,

        /** @var MediaDto[] */
        private ?array $media = null,
        private ?MetaDto $meta = null,

        /** @var QuestionDto[] */
        private ?array $questions = null,
    ) {}

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getType(): QuestionType
    {
        return QuestionType::from($this->questionType);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return MediaDto[]|null
     */
    public function getMedia(): ?array
    {
        return $this->media;
    }

    public function getMeta(): ?MetaDto
    {
        return $this->meta;
    }

    /**
     * @return QuestionDto[]|null
     */
    public function getQuestions(): ?array
    {
        return $this->questions;
    }
}