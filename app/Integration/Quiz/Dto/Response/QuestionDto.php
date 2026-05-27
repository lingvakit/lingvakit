<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Dto\Response;

use App\Domain\Quiz\Enum\QuestionTypeEnum;

class QuestionDto
{
    public function __construct(
        public string $uuid,
        public string $text,
        public QuestionTypeEnum $type,
        public ?string $explanation  = null,
        public ?int $points = null,
        public ?int $orderIndex = null,
        public ?array $settings = null,
        public QuestionAnswerDto $answer,

        /** @var QuestionOptionDto[] */
        public array $options = [],
    ) {}
}
