<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject\QuestionAnswer;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;

readonly class FreeTextAnswer implements AnswerValueObject
{
    public function __construct(
        private ?string $text = null,
    ) {}

    public function getQuestionType(): QuestionTypeEnum
    {
        return QuestionTypeEnum::FreeText;
    }

    public function getValue(): ?string
    {
        return $this->text;
    }

    public function toArray(): array
    {
        return [
            'questionType' => $this->getQuestionType()->value,
            'text' => $this->getValue(),
        ];
    }
}
