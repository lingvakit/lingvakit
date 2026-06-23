<?php
declare (strict_types=1);

namespace App\Application\Quiz\Dto\QuestionsGroup\Request;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use Symfony\Component\Uid\Uuid;

class QuestionsGroupCreateDto
{
    public function __construct(
        public Uuid $quizUuid,
        public Uuid $uuid,
        public string $title,
        public ?string $description = null,
        public ?int $orderIndex = null,
        public QuestionTypeEnum $questionType,
        public ?array $meta = null,
        public ?array $media = null,

        /** @var QuestionCreateDto[] */
        public array            $questions,
    ) {}

    public function convertToArray(): array
    {
        return [
            'quizUuid' => $this->quizUuid,
            'title' => $this->title,
            'questionType' => $this->questionType,
            'uuid' => $this->uuid,
            'description' => $this->description,
            'orderIndex' => $this->orderIndex,
            'meta' => $this->meta,
            'media' => !empty($this->media) ? $this->media : null,
            'questions' => $this->questions,
        ];
    }
}
