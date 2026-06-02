<?php
declare(strict_types=1);

namespace App\Application\Media\Helper;

use App\Application\Media\Dto\FileMetaDto;
use App\Domain\Media\Enum\FileType;
use Illuminate\Http\UploadedFile;

class MediaFileHelper
{
    public function prepareFileMetaDtoFromUploadedFile(string $fileUrl, UploadedFile $file): FileMetaDto
    {
        return new FileMetaDto(
            originalFilename: $file->getClientOriginalName(),
            filename: $this->getFilename($fileUrl),
            path: $this->getDirectoryPath($fileUrl),
            type: FileType::fromExtension($file->guessExtension()),
            size: $file->getSize(),
            authorId: auth()->user()->id ?? 1, // TODO: Remove hardcode
            altText: $file->getClientOriginalName(),
        );
    }

    private function getFilename(string $path): string
    {
        $pathArray = explode('/', $path);

        return end($pathArray);
    }

    private function getDirectoryPath(string $path): string
    {
        $pathArray = explode('/', $path);
        array_pop($pathArray);

        return implode('/', $pathArray);
    }
}
