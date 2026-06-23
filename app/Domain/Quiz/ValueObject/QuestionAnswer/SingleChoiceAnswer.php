<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject\QuestionAnswer;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;

readonly class SingleChoiceAnswer implements AnswerValueObject
{
    /**
     * @param string[] $optionUuids
     */
    public function __construct(
        private array $optionUuids
    ) {}

    public function getQuestionType(): QuestionTypeEnum
    {
        return QuestionTypeEnum::SingleChoice;
    }

    public function getValue(): array
    {
        return $this->optionUuids;
    }

    public function toArray(): array
    {
        return [
            'questionType' => $this->getQuestionType()->value,
            'value' => $this->getValue(),
        ];
    }
}
