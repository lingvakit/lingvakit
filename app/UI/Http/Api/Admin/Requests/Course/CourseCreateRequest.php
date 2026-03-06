<?php
declare (strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

final class CourseCreateRequest extends FormRequest
{
    private const string DEFAULT_DIFFICULTY_LEVEL = 'beginner';

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'difficultyLevel' => ['required', 'string'],
            'price' => ['required', 'string', 'max:50'],
            'duration' => ['required', 'integer', 'min:1'],
            'image' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function dto(): array
    {
        $validated = $this->validated();

        return [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'difficulty_level' => $validated['difficultyLevel'] ?? self::DEFAULT_DIFFICULTY_LEVEL,
            'price' => $validated['price'],
            'duration' => (int)$validated['duration'],
            'image' => $validated['image'] ?? null,
        ];
    }
}
