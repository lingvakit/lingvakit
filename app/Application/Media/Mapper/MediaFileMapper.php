<?php
declare(strict_types=1);

namespace App\Application\Media\Mapper;

use App\Application\Media\Dto\MediaFileDto;
use App\Models\MediaFile;

class MediaFileMapper
{
    public function fromModel(MediaFile $file): MediaFileDto
    {
        return new MediaFileDto(
            id: $file->id,
            fileName: $file->filename,
            url: $file->getPath(),
            type: $file->type,
        );
    }
}
