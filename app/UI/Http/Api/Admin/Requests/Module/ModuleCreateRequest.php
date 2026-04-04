<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\Module;

use App\Application\Module\Dto\RequestCreateModuleDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModuleCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'courseId' => ['required', 'integer', Rule::exists('lms_courses', 'id')],
            'title' => ['required', 'string', 'max:255'],
        ];
    }

    public function dto(): RequestCreateModuleDto
    {
        return new RequestCreateModuleDto(
            courseId: $this->input('courseId'),
            title: $this->string('title')->toString()
        );
    }
}
