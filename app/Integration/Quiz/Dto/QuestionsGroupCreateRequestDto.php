<?php
declare (strict_types=1);

namespace App\Integration\Quiz\Dto;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use Symfony\Component\Uid\Uuid;

class QuestionsGroupCreateRequestDto
{
    public function __construct(
        public Uuid $quizUuid,
        public Uuid $uuid,
        public string $title,
        public ?string $description = null,
        public ?int $orderIndex = null,
        public QuestionTypeEnum $questionType,
        public ?array $meta = null,
        public ?array $mediaFiles = null,
        public array $questions,
    ) {}
}
