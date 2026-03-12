<?php
declare(strict_types=1);

namespace App\Application\Media\Dto;

use App\Application\Media\Enum\FileType;

final readonly class MediaFileDto
{
    public function __construct(
        private int  $id,
        private string $fileName,
        private string $url,
        private FileType $type,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getType(): FileType
    {
        return $this->type;
    }
}
