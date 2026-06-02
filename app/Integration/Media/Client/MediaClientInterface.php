<?php
declare(strict_types=1);

namespace App\Integration\Media\Client;

use App\Integration\Media\Dto\Response\MediaFileDto;
use Illuminate\Http\UploadedFile;

interface MediaClientInterface
{
    public function uploadFile(UploadedFile $file): MediaFileDto;
}
