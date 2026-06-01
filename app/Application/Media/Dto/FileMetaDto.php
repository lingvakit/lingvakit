<?php
declare(strict_types=1);

namespace App\Application\Media\Dto;

use App\Domain\Media\Enum\FileType;

class FileMetaDto
{
    public function __construct(
        public string $originalFilename,
        public string $filename,
        public string $path,
        public FileType $type,
        public int $size,
        public int $authorId,
        public ?string $altText = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'title' => $this->originalFilename,
            'filename' => $this->filename,
            'path' => $this->path,
            'type' => $this->type,
            'size' => $this->size,
            'author_id' => $this->authorId,
            'alt' => $this->altText,
        ];
    }
}
