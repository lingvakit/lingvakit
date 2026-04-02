<?php
declare(strict_types = 1);

namespace App\UI\Http\Api\Admin\Requests\Lesson;

use App\Application\Course\Dto\Lesson\LessonUpdateDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LessonUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'imageMediaId' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'audioMediaId' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'videoMediaId' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'duration' => ['nullable', 'integer', 'min:1'],
            'orderIndex' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function dto(): LessonUpdateDto
    {
        return new LessonUpdateDto(
            title: $this->string('title')->toString(),
            duration: $this->integer('duration'),
            description: $this->string('description')->toString() ?: null,
            imageMediaId: $this->input('imageMediaId') ?: null,
            audioMediaId: $this->input('audioMediaId') ?: null,
            videoMediaId: $this->input('videoMediaId') ?: null,
            orderIndex: $this->integer('orderIndex'),
        );
    }
}
