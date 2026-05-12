<?php

namespace App\UI\Http\Api\Admin\Resources\Quiz;

use App\Application\Quiz\Dto\QuestionsGroup\Response\QuestionsGroupDto;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionsGroupResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var QuestionsGroupDto $this */
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'description' => $this->description,
            'orderIndex' => $this->orderIndex,
            'questionType' => $this->questionType,
        ];
    }
}
