<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject\MediaFile;

use App\Domain\Media\Enum\FileType;
use App\Domain\Quiz\ValueObject\MediaValueObject;

readonly class ImageFileVO implements MediaValueObject
{
    public function __construct(
        private int $mediaId,
        private ?string $altText = null,
    ) {}

    public function getMediaId(): int
    {
        return $this->mediaId;
    }

    public function getFileType(): FileType
    {
        return FileType::Image;
    }

    public function toArray(): array
    {
        return [
            'mediaId' => $this->getMediaId(),
            'type' => $this->getFileType(),
            'alt' => $this->altText,
        ];
    }
}
