<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Resources\Lesson;

use App\Application\Lesson\Dto\LessonDto;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var LessonDto $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description ?: null,
            'imageUrl' => $this->imageUrl ?: null,
            'audioUrl' => $this->audioUrl ?: null,
            'videoUrl' => $this->videoUrl ?: null,
            'duration' => $this->duration,
            'orderIndex' => $this->orderIndex ?: null,
        ];
    }
}
