<?php
declare(strict_types=1);

namespace App\Application\Quiz\Dto\QuestionsGroup\Request;

use App\Application\Quiz\Dto\QuestionsGroup\Request\Question\QuestionAnswerCreateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\Question\QuestionOptionCreateDto;
use App\Domain\Quiz\Enum\QuestionTypeEnum;
use Symfony\Component\Uid\Uuid;

class QuestionCreateDto
{
    public function __construct(
        public ?Uuid $groupUuid = null,
        public Uuid $uuid,
        public string $text,
        public ?string $explanation = null,
        public ?int $points = null,
        public ?int $orderIndex = null,
        public QuestionTypeEnum $type,
        public ?array $settings = null,

        /** @var QuestionOptionCreateDto[] */
        public array $options = [],
        public QuestionAnswerCreateDto $answer,
    ) {}
}
