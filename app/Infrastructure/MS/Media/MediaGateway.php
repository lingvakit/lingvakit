<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Media;

use App\Domain\Media\Repositories\MediaRepository;
use App\Helpers\FormatHelper;

class MediaGateway
{
    private const string DEFAULT_IMAGE_PATH = '/assets/cms/img/no-image.jpg';

    public function __construct(
        private readonly MediaClient $client,
        private readonly MediaRepository $repository,
    ) {
    }

    public function getMediaUrl(?int $fileId): ?string
    {
        if ($fileId === null) {
            return null;
        }

        $file = $this->repository->find($fileId);
        if ($file === null) {
            return null;
        }

        if ($file->type === 'image' && $file->filename === null) {
            return asset(self::DEFAULT_IMAGE_PATH);
        }

        return $this->client->getFileUrl($file->path, $file->filename);
    }

    public function getDurationText(int $duration): string
    {
        return FormatHelper::formatTimeLimit($duration);
    }
}
