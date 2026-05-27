<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Dto\Response;

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
