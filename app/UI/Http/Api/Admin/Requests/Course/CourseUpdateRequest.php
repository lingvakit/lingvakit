<?php
declare (strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\Course;

use App\Application\Course\Dto\CourseUpdateRequestDto;
use App\Domain\Course\Enum\CoursePaidTypeEnum;
use App\Domain\Course\Enum\DifficultyLevelEnum;
use App\UI\Http\Api\Admin\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

final class CourseUpdateRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'difficultyLevel' => ['nullable', new Enum(DifficultyLevelEnum::class)],
            'paidType' => ['nullable', new Enum(CoursePaidTypeEnum::class)],
            'price' => [
                'nullable',
                'numeric',
                Rule::requiredIf(
                    fn() => $this->enum('paidType', CoursePaidTypeEnum::class) === CoursePaidTypeEnum::Paid
                )
            ],
            'sale_price' => ['nullable', 'numeric'],
            'duration' => ['nullable', 'integer', 'min:1'],
            'categoryId' => ['nullable', 'integer', Rule::exists('lms_categories', 'id')],
            'image' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'video' => ['nullable', 'integer', Rule::exists('media_files', 'id')],
            'isNew' => ['nullable', 'boolean'],
            'isPublished' => ['nullable', 'boolean'],
            'publishDate' => ['nullable', 'date'],
            'isAllowed' => ['nullable', 'boolean'],
        ];
    }

    public function dto(): CourseUpdateRequestDto
    {
        return new CourseUpdateRequestDto(
            title: $this->fieldString('title'),
            description: $this->fieldString('description'),
            difficultyLevel: $this->fieldEnum('difficultyLevel', DifficultyLevelEnum::class),
            paidType: $this->fieldEnum('paidType', CoursePaidTypeEnum::class),
            price: $this->fieldFloat('price'),
            salePrice: $this->fieldFloat('sale_price'),
            duration: $this->fieldInt('duration'),
            categoryId: $this->fieldInt('categoryId'),
            imageMediaId: $this->fieldInt('image'),
            videoMediaId: $this->fieldInt('video'),
            isNew: $this->fieldBool('isNew'),
            isPublished: $this->fieldBool('isPublished'),
            publishDate: $this->fieldDate('publishDate'),
            isAllowed: $this->fieldBool('isAllowed'),
        );
    }
}
