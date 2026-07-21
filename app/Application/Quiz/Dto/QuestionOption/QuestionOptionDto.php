<?php
declare(strict_types=1);

namespace App\Application\Quiz\Dto\QuestionOption;

final class QuestionOptionDto
{
    public function __construct(
        public string $uuid,
        public ?string $text = null,
        public ?string $matchKey = null,
        public ?int $orderIndex = null,
        public ?array $media = [],
        public ?array $settings = [],
    ) {}

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'text' => $this->text,
            'matchKey' => $this->matchKey,
            'orderIndex' => $this->orderIndex,
            'media' => $this->media,
            'settings' => $this->settings,
        ];
    }
}
