<?php
declare (strict_types = 1);

namespace App\UI\Http\Api\Admin\Resources\Quiz;

use App\Application\Quiz\Dto\Question\QuestionDto;
use App\Application\Quiz\Dto\QuestionOption\QuestionOptionDto;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var QuestionDto $this */
        return [
            'uuid' => $this->uuid,
            'text' => $this->text,
            'type' => $this->type,
            'explanation' => $this->explanation,
            'points' => $this->points,
            'orderIndex' => $this->orderIndex,
            'media' => $this->media,
            'settings' => $this->settings,
            'answer' => $this->answer,
            'options' => array_map(
                fn(QuestionOptionDto $option) => $option->toArray(),
                $this->options
            )
        ];
    }
}
