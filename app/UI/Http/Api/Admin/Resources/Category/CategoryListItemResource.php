<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Resources\Category;

use App\Application\Category\Dto\CategoryListItemDto;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryListItemResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var CategoryListItemDto $this */
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
        ];
    }
}
