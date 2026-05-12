<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Dto\QuestionsGroup\Response;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Integration\Quiz\Dto\QuestionsGroup\Response\Question\QuestionOptionDto;

class QuestionDto
{
    public function __construct(
        public string $uuid,
        public string $text,
        public QuestionTypeEnum $questionType,
        public ?string $explanation  = null,
        public ?int $points = null,
        public ?int $orderIndex = null,
        public ?array $settings = null,

        /** @var QuestionOptionDto[] */
        public array $options,
        public array $answer,
    ) {}
}
