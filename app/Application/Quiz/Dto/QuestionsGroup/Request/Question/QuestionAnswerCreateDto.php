<?php
declare(strict_types=1);

namespace App\Application\Quiz\Dto\QuestionsGroup\Request\Question;

use App\Domain\Quiz\Enum\QuestionTypeEnum;

class QuestionAnswerCreateDto
{
    public function __construct(
        public QuestionTypeEnum $questionType,
        public mixed $value = null,
    ) {}

    public function convertToArray(): array
    {
        return [
            'questionType' => $this->questionType,
            'value' => $this->value,
        ];
    }
}
