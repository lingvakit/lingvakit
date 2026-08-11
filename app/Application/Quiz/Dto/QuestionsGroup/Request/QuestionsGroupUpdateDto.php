<?php
declare (strict_types=1);

namespace App\Application\Quiz\Dto\QuestionsGroup\Request;

class QuestionsGroupUpdateDto
{
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?int $orderIndex = null,
        public ?array $meta = null,
        public ?array $media = null,
    ) {}

    public function convertToArray(): array
    {
        $data = [];

        if (isset($this->title)) {
            $data['title'] = $this->title;
        }

        if (isset($this->description)) {
            $data['description'] = $this->description;
        }

        if (isset($this->orderIndex)) {
            $data['orderIndex'] = $this->orderIndex;
        }

        if (isset($this->meta)) {
            $data['meta'] = $this->meta;
        }

        if (isset($this->media)) {
            $data['media'] = $this->media;
        }

        return $data;
    }
}
