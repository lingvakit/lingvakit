<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Dto\QuestionsGroup\Response;

use App\Domain\Quiz\Enum\QuestionTypeEnum;

class QuestionsGroupDto
{
    public function __construct(
        public string $uuid,
        public string $title,
        public ?string $description = null,
        public QuestionTypeEnum $questionType,
        public ?int $orderIndex = null,
        public ?array $mediaFiles = null,
        public ?array $meta = null,

        /** @var QuestionDto[] */
        public array $questions,
    ) {}
}
