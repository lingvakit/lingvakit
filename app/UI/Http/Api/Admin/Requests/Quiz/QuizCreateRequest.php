<?php

namespace App\UI\Http\Api\Admin\Requests\Quiz;

use App\Domain\Quiz\Enum\QuizStatusEnum;
use App\Integration\Quiz\Dto\QuizCreateRequestDto;
use App\UI\Http\Api\Admin\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\Uid\Uuid;

class QuizCreateRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'moduleId' => ['required', 'integer', Rule::exists('lms_stages', 'id')],
            'uuid' => ['required', 'uuid'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'imageMediaId' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'audioMediaId' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'videoMediaId' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'timeLimit' => ['required', 'integer', 'min:1'],
            'passingScore' => ['required', 'integer', 'min:0', 'max:100'],
            'status' => ['required', new Enum(QuizStatusEnum::class)],
        ];
    }

    public function dto(): QuizCreateRequestDto
    {
        return new QuizCreateRequestDto(
            moduleId: $this->fieldInt('moduleId'),
            uuid: Uuid::fromString($this->fieldString('uuid')),
            title: $this->fieldString('title'),
            description: $this->fieldString('description'),
            imageMediaId: $this->fieldInt('imageMediaId'),
            audioMediaId: $this->fieldInt('audioMediaId'),
            videoMediaId: $this->fieldInt('videoMediaId'),
            timeLimit: $this->fieldInt('timeLimit'),
            passingScore: $this->fieldInt('passingScore'),
            status: $this->fieldEnum('status', QuizStatusEnum::class),
        );
    }
}
