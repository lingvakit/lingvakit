<?php
declare (strict_types=1);

namespace App\UI\Http\Api\Admin\Resources\Module;

use App\Application\Module\Dto\ModuleDto;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var ModuleDto $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'topics' => $this->topics,
        ];
    }
}
