<?php

namespace App\UI\Http\Api\Admin\Requests\Quiz;

use App\Domain\Quiz\Enum\QuizStatusEnum;
use App\Integration\Quiz\Dto\Request\Quiz\QuizUpdateRequestDto;
use App\UI\Http\Api\Admin\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class QuizUpdateRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'moduleId' => ['nullable', 'integer', Rule::exists('lms_stages', 'id')],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'imageMediaId' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'audioMediaId' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'videoMediaId' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'timeLimit' => ['nullable', 'integer', 'min:1'],
            'passingScore' => ['nullable', 'integer', 'min:0', 'max:100'],
            'status' => ['nullable', new Enum(QuizStatusEnum::class)],
        ];
    }

    public function dto(): QuizUpdateRequestDto
    {
        return new QuizUpdateRequestDto(
            moduleId: $this->fieldInt('moduleId'),
            title: $this->fieldString('title'),
            description: $this->fieldString('description'),
            imageMediaId: $this->fieldInt('imageMediaId'),
            audioMediaId: $this->fieldInt('audioMediaId'),
            videoMediaId: $this->fieldInt('videoMediaId'),
            timeLimit: $this->fieldInt('timeLimit'),
            passingScore: $this->fieldInt('passingScore'),
            status: $this->fieldEnum('status', QuizStatusEnum::class),
            orderIndex: $this->fieldInt('orderIndex'),
        );
    }
}
