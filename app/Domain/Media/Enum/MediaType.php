<?php
declare(strict_types=1);

namespace App\Domain\Media\Enum;

enum MediaType: string
{
    case Image = "image";
    case Audio = 'audio';
    case Video = 'video';
    case Document = 'document';

    public static function fromExtension(string $extension): self
    {
        $fileType = FileType::fromExtension($extension);

        return $fileType === FileType::File
            ? MediaType::Document
            : MediaType::from($fileType->value);
    }
}
