<?php

declare(strict_types=1);

namespace App\Application\Quiz\Enum;

enum MediaType: string
{
    case Audio = 'audio';
    case Image = 'image';
    case Video = 'video';
    case File = 'file';
}