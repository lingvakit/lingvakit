<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject\QuestionAnswer;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;

readonly class BooleanChoiceAnswer implements AnswerValueObject
{
    public function __construct(
        private bool $boolean,
    ) {
    }

    public function getQuestionType(): QuestionTypeEnum
    {
        return QuestionTypeEnum::Boolean;
    }

    public function getValue(): bool
    {
        return $this->boolean;
    }

    public function toArray(): array
    {
        return [
            'questionType' => $this->getQuestionType()->value,
            'boolean' => $this->getValue(),
        ];
    }
}
