<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject;

use App\Domain\Quiz\Enum\QuestionTypeEnum;

interface AnswerValueObject
{
    public function getQuestionType(): QuestionTypeEnum;
    public function getValue(): mixed;
    public function toArray(): array;
}
