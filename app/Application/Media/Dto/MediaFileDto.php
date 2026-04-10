<?php
declare(strict_types=1);

namespace App\Application\Media\Dto;

use App\Application\Media\Enum\FileType;

final readonly class MediaFileDto
{
    public function __construct(
        public int $id,
        public string $fileName,
        public string $url,
        public FileType $type,
    ) {}
}
