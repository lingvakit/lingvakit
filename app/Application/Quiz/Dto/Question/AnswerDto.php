<?php

declare(strict_types=1);

namespace App\Application\Quiz\Dto\Question;

use App\Application\Quiz\Enum\QuestionType;

readonly class AnswerDto
{
    public function __construct(
        private ?QuestionType $questionType = null,
        private ?string $value = null,
    ) {
    }

    public function getQuestionType(): ?QuestionType
    {
        return $this->questionType;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}