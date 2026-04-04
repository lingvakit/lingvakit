<?php
declare(strict_types = 1);

namespace App\UI\Http\Api\Admin\Requests\Lesson;

use App\Application\Lesson\Dto\LessonCreateRequestDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LessonCreateRequest extends FormRequest
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
            moduleId: $this->input('moduleId'),
            title: $this->string('title')->toString(),
            duration: $this->integer('duration'),
            description: $this->string('description')->toString() ?: null,
            imageMediaId: $this->input('imageMediaId') ?: null,
            audioMediaId: $this->input('audioMediaId') ?: null,
            videoMediaId: $this->input('videoMediaId') ?: null,
        );
    }
}
