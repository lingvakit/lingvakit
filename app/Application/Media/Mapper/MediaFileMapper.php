<?php
declare(strict_types=1);

namespace App\Application\Media\Mapper;

use App\Application\Media\Dto\MediaFileDto;
use App\Domain\Media\Enum\FileType;
use App\Models\MediaFile;

class MediaFileMapper
{
    public function fromModel(MediaFile $file): MediaFileDto
    {
        return new MediaFileDto(
            id: $file->id,
            fileName: $file->filename,
            url: $file->getPath(),
            type: FileType::from($file->type),
        );
    }
}
