<?php
declare(strict_types = 1);

namespace App\UI\Http\Api\Admin\Requests\Lesson;

use App\Application\Lesson\Dto\LessonUpdateRequestDto;
use App\UI\Http\Api\Admin\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;

class LessonUpdateRequest extends AbstractFormRequest
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
            'duration' => ['nullable', 'integer', 'min:1'],
            'orderIndex' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function dto(): LessonUpdateRequestDto
    {
        return new LessonUpdateRequestDto(
            moduleId: $this->fieldInt('moduleId'),
            title: $this->fieldString('title'),
            duration: (int)$this->fieldInt('duration'),
            description: $this->fieldString('description'),
            imageMediaId: $this->fieldInt('imageMediaId'),
            audioMediaId: $this->fieldInt('audioMediaId'),
            videoMediaId: $this->fieldInt('videoMediaId'),
            orderIndex: $this->fieldInt('orderIndex'),
        );
    }
}
