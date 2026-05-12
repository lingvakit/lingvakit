<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Dto\QuestionsGroup\Response\Question;

class QuestionOptionDto
{
    public function __construct(
        public string $uuid,
        public ?string $text = null,
        public ?int $matchKey = null,
        public ?int $orderIndex = null,
        public ?array $settings = null,
    ) {}
}
