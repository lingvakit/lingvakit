<?php
declare(strict_types=1);

namespace App\Integration\Media\Client;

use App\Domain\Media\Enum\MediaType;
use App\Integration\Media\Dto\Response\MediaFileDto;
use Illuminate\Http\UploadedFile;

class MediaClient extends BaseClient implements MediaClientInterface
{
    public function uploadFile(UploadedFile $file): MediaFileDto
    {
        $fileStream = fopen($file->getRealPath(), 'r');
        $fileExtension = $file->guessExtension();
        $fileType = MediaType::fromExtension($fileExtension)->value;

        $url = "{$this->getMsUrl()}/api/{$fileType}/catalog_course/save";

        try {
            $response = $this->http()
                ->attach(
                    'file',
                    $fileStream,
                    $file->getClientOriginalName()
                )
                ->post($url);

            $response->throw();

            return new MediaFileDto(
                url: $response->body(),
            );
        } finally {
            if (is_resource($fileStream)) {
                fclose($fileStream);
            }
        }
    }
}
