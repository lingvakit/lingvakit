<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Dto\Response;

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
    ) {
    }
}
