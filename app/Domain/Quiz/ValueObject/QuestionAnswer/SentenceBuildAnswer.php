<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject\QuestionAnswer;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;
use Symfony\Component\Uid\Uuid;

readonly class SentenceBuildAnswer implements AnswerValueObject
{
    /** @param Uuid[] $sequence */
    public function __construct(
        private array $sequence,
    ) {
    }

    public function getQuestionType(): QuestionTypeEnum
    {
        return QuestionTypeEnum::SentenceBuild;
    }

    /**
     * @return Uuid[]
     */
    public function getValue(): array
    {
        return $this->sequence;
    }

    public function toArray(): array
    {
        return [
            'questionType' => $this->getQuestionType()->value,
            'sequence' => $this->getValue(),
        ];
    }
}
