<?php
declare(strict_types=1);

namespace App\Domain\Quiz\Entity;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;
use App\Domain\Quiz\ValueObject\MediaValueObject;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class QuestionEntity
{
    public function __construct(
        private readonly int $id,
        private readonly Uuid $uuid,
        private string $text,
        private ?string $explanation = null,
        private int $points,
        private ?int $orderIndex = null,
        private QuestionTypeEnum $type,

        /** @var MediaValueObject[] */
        private ?array $media = [],
        private ?array $settings = null,
        private AnswerValueObject $answer,

        /** @var QuestionOptionEntity[] */
        private ?array $options = [],
        private DateTimeImmutable $createdAt,
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

    public function getText(): string
    {
        return $this->text;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(?string $explanation): self
    {
        $this->explanation = $explanation;
        return $this;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function getOrderIndex(): ?int
    {
        return $this->orderIndex;
    }

    public function getType(): QuestionTypeEnum
    {
        return $this->type;
    }

    public function getMedia(): ?array
    {
        return $this->media;
    }

    public function addMedia(MediaValueObject $mediaFile): void
    {
        $this->media[] = $mediaFile;
    }

    public function getSettings(): ?array
    {
        return $this->settings;
    }

    public function getAnswer(): AnswerValueObject
    {
        return $this->answer;
    }

    /**
     * @return QuestionOptionEntity[]|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function addOption(QuestionOptionEntity $option): void
    {
        $this->options[] = $option;
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
