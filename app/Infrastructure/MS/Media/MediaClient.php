<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Media;

class MediaClient
{
    public function __construct(
        private readonly string $baseUrl,
        private string $token,
    ) {}

    public function getFileUrl(string $path, string $filename): string
    {
        $flattenedPath = str_replace('/', '_', trim($path, '/'));

        return "$this->baseUrl/$flattenedPath/$filename";
    }
}
