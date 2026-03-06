<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Resources\Course;

use App\Application\Course\Dto\CourseListItemDto;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseListItemResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var CourseListItemDto $this */
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'createdAt' => $this->getCreatedAt(),
            'imageUrl' => $this->getImageUrl(),
        ];
    }
}
