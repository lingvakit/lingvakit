<?php
declare (strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\Course;

use App\Application\Course\Dto\CreateCourseDto;
use App\Application\Course\Enum\DifficultyLevelEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

final class CourseCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'difficultyLevel' => ['required', new Enum(DifficultyLevelEnum::class)],
            'price' => ['nullable', 'numeric'],
            'sale_price' => ['nullable', 'numeric'],
            'duration' => ['nullable', 'integer', 'min:1'],
            'categoryId' => ['required', 'integer', Rule::exists('lms_categories', 'id')],
            'image' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'video' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
        ];
    }

    public function dto(): CreateCourseDto
    {
        return new CreateCourseDto(
            title: $this->string('title')->toString(),
            description: $this->string('description')->toString() ?: null,
            difficultyLevel: $this->enum('difficultyLevel', DifficultyLevelEnum::class),
            price: $this->input('price'),
            salePrice: $this->input('sale_price'),
            duration: $this->integer('duration'),
            categoryId: $this->integer('categoryId'),
            imageId: $this->input('image'),
            videoId: $this->input('video'),
        );
    }
}
