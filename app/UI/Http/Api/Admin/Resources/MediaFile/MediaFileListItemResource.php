<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Resources\MediaFile;

use App\Application\Media\Dto\MediaFileDto;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaFileListItemResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var MediaFileDto $this */
        return [
            'id' => $this->getId(),
            'fileName' => $this->getFileName(),
            'type' => $this->getType()->value,
            'url' => $this->getUrl(),
        ];
    }
}
