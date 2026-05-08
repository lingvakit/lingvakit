<?php
declare(strict_types=1);

namespace App\Application\Quiz\Dto\QuestionsGroup\Response;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use Symfony\Component\Uid\Uuid;

class QuestionsGroupDto
{
    public function __construct(
        public Uuid $uuid,
        public string $title,
        public ?string $description = null,
        public ?int $orderIndex = null,
        public QuestionTypeEnum $questionType,
    ) {}
}
