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
    ) {
    }
}
