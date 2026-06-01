<?php
declare(strict_types=1);

namespace App\Application\Media\Dto;

class MediaFileCreateRequestDto
{
    public function __construct(
        public ?string $title = null,
        public ?string $altText = null,
    ) {
    }

    public function convertToArray(): array
    {
        return [
            'title' => $this->title,
            'alt' => $this->altText,
        ];
    }
}
