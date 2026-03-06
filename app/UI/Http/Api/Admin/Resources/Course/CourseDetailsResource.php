<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Resources\Course;

use App\Application\Course\Dto\CourseDetailsDto;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var CourseDetailsDto $this */
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'price' => $this->getPrice(),
            'duration' => $this->getDuration(),
            'createdAt' => $this->getCreatedAt(),
            'description' => $this->getDescription(),
            'imageUrl' => $this->getImageUrl(),
            'author' => $this->getAuthor(),
            'modules' => $this->getModules(),
        ];
    }
}
