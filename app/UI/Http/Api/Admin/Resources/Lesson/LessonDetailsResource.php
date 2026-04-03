<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Resources\Lesson;

use App\Application\Course\Dto\Lesson\LessonDetailsDto;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var LessonDetailsDto $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'imageUrl' => $this->imageUrl,
            'audioUrl' => $this->audioUrl,
            'videoUrl' => $this->videoUrl,
            'duration' => $this->duration,
            'orderIndex' => $this->orderIndex,
        ];
    }
}
