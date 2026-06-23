<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject\QuestionAnswer;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;
use App\Domain\Quiz\ValueObject\QuestionAnswer\Dto\AnswerMatchItemDto;

readonly class MatchAnswer implements AnswerValueObject
{
    /** @param AnswerMatchItemDto[] $pairs */
    public function __construct(
        private array $pairs,
    ) {
    }

    public function getQuestionType(): QuestionTypeEnum
    {
        return QuestionTypeEnum::FillInBlank;
    }

    /**
     * @return AnswerMatchItemDto[]
     */
    public function getValue(): array
    {
        return $this->pairs;
    }

    public function toArray(): array
    {
        return [
            'questionType' => $this->getQuestionType()->value,
            'blanks' => $this->getValue(),
        ];
    }
}
