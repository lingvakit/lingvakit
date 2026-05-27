<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Dto\Response;

use App\Domain\Media\Enum\FileType;

class MediaFileDto
{
    public function __construct(
        public int $mediaId,
        public FileType $type,
        public ?string $altText = null,
    ) {
    }
}
