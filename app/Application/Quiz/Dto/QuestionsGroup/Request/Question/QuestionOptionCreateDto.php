<?php
declare(strict_types=1);

namespace App\Application\Quiz\Dto\QuestionsGroup\Request\Question;

use Symfony\Component\Uid\Uuid;

class QuestionOptionCreateDto
{
    public function __construct(
        public Uuid $uuid,
        public ?string $text = null,
        public ?Uuid $matchKey = null,
        public ?int $orderIndex = null,
        public ?array $settings = null,
    ) {}
}
