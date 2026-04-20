<?php
declare(strict_types=1);

namespace App\Domain\Media\Enum;

enum FileType: string
{
    case Audio = 'audio';
    case File = 'file';
    case Image = 'image';
    case Video = 'video';
}
