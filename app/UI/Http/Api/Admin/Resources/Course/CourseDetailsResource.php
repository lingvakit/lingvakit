<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Resources\Course;

use App\Application\Course\Dto\CourseDto;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var CourseDto $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'duration' => $this->duration,
            'category' => $this->category,
            'createdAt' => $this->createdAt,
            'description' => $this->description,
            'imageUrl' => $this->imageUrl,
            'author' => $this->author,
            'modules' => $this->modules,
        ];
    }
}
