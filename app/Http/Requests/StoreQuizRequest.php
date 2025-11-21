<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'min:3', 'max:255'],
            'duration' => ['required', 'numeric', 'min:0'],
            'passing_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'category_id' => ['nullable', 'integer'],
            'category' => ['nullable', 'string', 'max:255'],
            'passed_topics' => ['nullable', 'array'],
            'passed_topics.*' => ['integer'],

            'image' => ['nullable', 'integer'],
            'video' => ['nullable', 'integer'],
            'audio' => ['nullable', 'integer'],

            'status' => ['nullable', 'string', 'in:draft,published'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => $this->filled('title') ? trim($this->title) : null,
            'duration' => $this->filled('duration') ? (int)$this->input('duration') : null,
            'passing_score' => $this->filled('passing_score') ? (int)$this->input('passing_score') : null,
            'category_id' => $this->filled('category_id') ? (int)$this->input('category_id') : null,
            'image' => $this->has('image') ? (int) $this->input('image') : null,
            'video' => $this->has('video') ? (int) $this->input('video') : null,
            'audio' => $this->has('audio') ? (int) $this->input('audio') : null,
        ]);
    }
}
