<?php
declare(strict_types=1);

namespace App\Domain\Quiz\Entity;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Domain\Quiz\ValueObject\MediaValueObject;
use App\Domain\Quiz\ValueObject\MetaValueObject;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class QuestionGroupEntity
{
    public function __construct(
        private readonly Uuid $uuid,
        private string $title,
        private ?string $description = null,
        private ?int $orderIndex = null,
        private QuestionTypeEnum $questionType,

        /** @var QuestionEntity[] */
        private ?array $questions = null,

        /** @var MediaValueObject[] */
        private ?array $media = null,

        private ?MetaValueObject $meta = null,
        private DateTimeImmutable $createdAt,
        private ?DateTimeImmutable $updatedAt = null,
    ) {}

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
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

    public function getOrderIndex(): ?int
    {
        return $this->orderIndex;
    }

    public function setOrderIndex(?int $orderIndex): self
    {
        $this->orderIndex = $orderIndex;
        return $this;
    }

    public function getQuestionType(): QuestionTypeEnum
    {
        return $this->questionType;
    }

    /**
     * @return QuestionEntity[]|null
     */
    public function getQuestions(): ?array
    {
        return $this->questions;
    }

    public function addQuestion(QuestionEntity $questionEntity): void
    {
        $this->questions[] = $questionEntity;
    }

    /**
     * @return MediaValueObject[]|null
     */
    public function getMedia(): ?array
    {
        return $this->media;
    }

    public function addMedia(MediaValueObject $mediaFile): self
    {
        $this->media[] = $mediaFile;
        return $this;
    }

    public function unsetMedia(): self
    {
        $this->media = [];
        return $this;
    }

    public function getMeta(): ?MetaValueObject
    {
        return $this->meta;
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
