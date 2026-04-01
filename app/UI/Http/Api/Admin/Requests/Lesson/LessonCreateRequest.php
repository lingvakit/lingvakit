<?php
declare(strict_types = 1);

namespace App\UI\Http\Api\Admin\Requests\Lesson;

use App\Application\Course\Dto\LessonCreateDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LessonCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'audio' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'video' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'duration' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function dto(): LessonCreateDto
    {
        return new LessonCreateDto(
            title: $this->string('title')->toString(),
            duration: $this->integer('duration'),
            description: $this->string('description')->toString() ?: null,
            imageMediaId: $this->input('image') ?: null,
            audioMediaId: $this->input('audio') ?: null,
            videoMediaId: $this->input('video') ?: null,
        );
    }
}
