<?php
declare(strict_types=1);

namespace App\Integration\Media\Exception;

class MediaFileUploadFailedException extends MediaClientException
{
    public function __construct(
        string $message = "File uploading has been failed",
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
