<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\Module;

use App\Application\Module\Dto\CreateModuleDto;
use Illuminate\Foundation\Http\FormRequest;

class ModuleCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
        ];
    }

    public function dto(): CreateModuleDto
    {
        return new CreateModuleDto(
            title: $this->string('title')->toString()
        );
    }
}
