<?php
declare(strict_types=1);

namespace App\Application\Quiz\Dto\QuestionAnswer;

use App\Domain\Quiz\Enum\QuestionTypeEnum;

class QuestionAnswerDto
{
    public function __construct(
        public QuestionTypeEnum $questionType,
        public ?array $value = null,
        public ?bool $boolean = null,
        public ?array $blanks = null,
        public ?array $pairs = null,
        public ?array $sequence = null,
        public ?string $text = null,
    ) {}

    public function toArray(): array
    {
        return [
            'questionType' => $this->questionType->value,
            'value' => $this->value,
            'boolean' => $this->boolean,
            'blanks' => $this->blanks,
            'pairs' => $this->pairs,
            'sequence' => $this->sequence,
            'text' => $this->text,
        ];
    }
}
