<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Resources\MediaFile;

use App\Application\Media\Dto\MediaFileDto;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaFileDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var MediaFileDto $this */
        return [
            'id' => $this->id,
            'fileName' => $this->fileName,
            'url' => $this->url,
            'type' => $this->type->value,
        ];
    }
}
