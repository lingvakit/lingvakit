<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Resources\Quiz;

use App\Integration\Quiz\Dto\QuizDto;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var QuizDto $this */
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'description' => $this->description ?: null,
            'imageFile' => $this->imageFile,
            'audioFile' => $this->audioFile,
            'videoFile' => $this->videoFile,
            'timeLimit' => $this->timeLimit,
            'passingScore' => $this->passingScore,
            'orderIndex' => $this->orderIndex,
            'status' => $this->status,
        ];
    }
}
