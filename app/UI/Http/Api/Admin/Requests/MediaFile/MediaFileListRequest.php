<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\MediaFile;

use Illuminate\Foundation\Http\FormRequest;

class MediaFileListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['nullable', 'string'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'q' => ['nullable', 'string', 'max:200'],
        ];
    }

    public function typeString(): string
    {
        return trim((string)($this->validated('type') ?? ''));
    }

    public function perPage(): int
    {
        return (int)($this->validated('per_page') ?? 20);
    }

    public function queryString(): string
    {
        return trim((string)($this->validated('q') ?? ''));
    }
}
