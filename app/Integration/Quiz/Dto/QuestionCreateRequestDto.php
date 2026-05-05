<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Dto;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use Symfony\Component\Uid\Uuid;

class QuestionCreateRequestDto
{
    public function __construct(
        public Uuid $uuid,
        public string $text,
        public ?string $explanation = null,
        public ?int $points = null,
        public ?int $orderIndex = null,
        public ?array $settings = null,
        public array $options = [],
        public $answer,
    ) {}
}
