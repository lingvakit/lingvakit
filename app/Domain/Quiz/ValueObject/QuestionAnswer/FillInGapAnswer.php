<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject\QuestionAnswer;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;
use App\Domain\Quiz\ValueObject\QuestionAnswer\Dto\AnswerFIllInBlankItemDto;

readonly class FillInGapAnswer implements AnswerValueObject
{
    /** @param AnswerFIllInBlankItemDto[] $blanks */
    public function __construct(
        private array $blanks,
    ) {
    }

    public function getQuestionType(): QuestionTypeEnum
    {
        return QuestionTypeEnum::FillInBlank;
    }

    /**
     * @return AnswerFIllInBlankItemDto[]
     */
    public function getValue(): array
    {
        return $this->blanks;
    }

    public function toArray(): array
    {
        return [
            'questionType' => $this->getQuestionType()->value,
            'blanks' => $this->getValue(),
        ];
    }
}
