<?php

declare(strict_types=1);

namespace App\Application\Quiz\Dto;

use App\Application\Quiz\Dto\Question\AnswerDto;
use App\Application\Quiz\Enum\QuestionType;

readonly class QuestionDto
{
    public function __construct(
        private string     $text,
        private string     $type,
        private int        $points,
        private ?string    $explanation = null,
        private ?int       $orderIndex = null,
        private ?array     $settings = null,
        private ?AnswerDto $answer = null,

        /** @var QuestionOptionDto[] */
        private ?array     $options = null,
    ) {}

    public function getText(): string
    {
        return $this->text;
    }

    public function getType(): QuestionType
    {
        return QuestionType::from($this->type);
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function getOrderIndex(): ?int
    {
        return $this->orderIndex;
    }

    public function getSettings(): ?array
    {
        return $this->settings;
    }

    /**
     * @return AnswerDto|null
     */
    public function getAnswer(): ?AnswerDto
    {
        return $this->answer;
    }

    /**
     * @return QuestionOptionDto[]|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }
}