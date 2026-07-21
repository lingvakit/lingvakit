<?php
declare(strict_types=1);

namespace App\Application\Quiz\Dto\Question;

use App\Application\Quiz\Dto\QuestionAnswer\QuestionAnswerDto;
use App\Application\Quiz\Dto\QuestionOption\QuestionOptionDto;
use App\Domain\Quiz\Enum\QuestionTypeEnum;

final class QuestionDto
{
    public function __construct(
        public string $uuid,
        public string $text,
        public QuestionTypeEnum $type,
        public ?string $explanation = null,
        public ?int $points = null,
        public ?int $orderIndex = null,
        public ?array $media = [],
        public ?array $settings = null,
        public QuestionAnswerDto $answer,

        /** @var QuestionOptionDto[] */
        public ?array $options = null,
    ) {}

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'text' => $this->text,
            'type' => $this->type->value,
            'explanation' => $this->explanation,
            'points' => $this->points,
            'orderIndex' => $this->orderIndex,
            'media' => $this->media,
            'settings' => $this->settings,
            'answer' => $this->answer->toArray(),
            'options' => array_map(
                fn(QuestionOptionDto $option) => $option->toArray(),
                $this->options
            ),
        ];
    }
}