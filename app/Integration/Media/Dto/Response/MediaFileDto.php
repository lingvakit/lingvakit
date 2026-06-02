<?php
declare(strict_types=1);

namespace App\Integration\Media\Dto\Response;

final readonly class MediaFileDto
{
    public function __construct(
        public string $url,
    ) {}
}
