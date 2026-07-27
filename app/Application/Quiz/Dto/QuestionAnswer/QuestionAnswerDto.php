<?php
declare(strict_types=1);

namespace App\Application\Quiz\Dto\QuestionAnswer;

use App\Domain\Quiz\Enum\QuestionTypeEnum;

class QuestionAnswerDto
{
    public function __construct(
        public QuestionTypeEnum $questionType,
        public mixed $value = null,
    ) {}

    public function toArray(): array
    {
        return [
            'questionType' => $this->questionType->value,
            'value' => $this->value,
        ];
    }
}
