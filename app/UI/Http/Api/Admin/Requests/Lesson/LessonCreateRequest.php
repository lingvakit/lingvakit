<?php
declare(strict_types = 1);

namespace App\UI\Http\Api\Admin\Requests\Lesson;

use App\Application\Lesson\Dto\LessonCreateRequestDto;
use App\UI\Http\Api\Admin\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;

class LessonCreateRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'moduleId' => ['required', 'integer', Rule::exists('lms_stages', 'id')],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'imageMediaId' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'audioMediaId' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'videoMediaId' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'duration' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function dto(): LessonCreateRequestDto
    {
        return new LessonCreateRequestDto(
            moduleId: $this->fieldInt('moduleId'),
            title: $this->fieldString('title'),
            duration: $this->fieldInt('duration') ?? 0,
            description: $this->fieldString('description'),
            imageMediaId: $this->fieldInt('imageMediaId'),
            audioMediaId: $this->fieldInt('audioMediaId'),
            videoMediaId: $this->fieldInt('videoMediaId'),
        );
    }
}
