<?php
declare(strict_types=1);

namespace App\Application\Media\Handlers;

use App\Application\Media\Dto\MediaFileCreateRequestDto;
use App\Application\Media\Dto\MediaFileDto;
use Illuminate\Http\UploadedFile;

interface UploadMediaFileHandlerInterface
{
    public function handle(
        UploadedFile $file,
        ?MediaFileCreateRequestDto $dto = null
    ): MediaFileDto;
}
