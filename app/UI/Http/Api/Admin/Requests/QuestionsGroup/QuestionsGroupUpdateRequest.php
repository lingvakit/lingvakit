<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\QuestionsGroup;

use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionsGroupUpdateDto;
use App\UI\Http\Api\Admin\Requests\AbstractFormRequest;

class QuestionsGroupUpdateRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'orderIndex' => ['nullable', 'integer'],
            'meta' => ['nullable', 'array'],
            'mediaFiles' => ['nullable', 'array'],
        ];
    }

    public function dto(): QuestionsGroupUpdateDto
    {
        return new QuestionsGroupUpdateDto(
            title: $this->fieldString('title') ?? null,
            description: $this->fieldString('description'),
            orderIndex: $this->fieldInt('orderIndex'),
            meta: null,
            media: null,
        );
    }
}
