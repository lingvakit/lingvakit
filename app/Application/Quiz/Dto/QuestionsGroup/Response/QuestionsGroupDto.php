<?php
declare(strict_types=1);

namespace App\Application\Quiz\Dto\QuestionsGroup\Response;

use App\Application\Quiz\Dto\Question\QuestionDto;
use App\Domain\Quiz\Enum\QuestionTypeEnum;
use Symfony\Component\Uid\Uuid;

final class QuestionsGroupDto
{
    public function __construct(
        public Uuid $uuid,
        public string $title,
        public ?string $description = null,
        public ?int $orderIndex = null,
        public QuestionTypeEnum $questionType,
        public ?array $media = null,
        public ?array $meta = null,

        /** @var QuestionDto[] */
        public ?array $questions = [],
    ) {}
}
