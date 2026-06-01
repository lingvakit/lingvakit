<?php
declare(strict_types=1);

namespace App\Domain\Media\Enum;

enum FileType: string
{
    case Audio = 'audio';
    case File = 'file';
    case Image = 'image';
    case Video = 'video';

    public static function fromExtension(string $extension): self
    {
        return match (strtolower($extension)) {
            'jpg', 'jpeg', 'png', 'gif' => self::Image,
            'mp3', 'wav' => self::Audio,
            'mp4' => self::Video,
            'doc', 'docx', 'xls', 'xlsx', 'pdf' => self::File,
        };
    }
}
