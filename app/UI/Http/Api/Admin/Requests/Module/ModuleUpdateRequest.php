<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\Module;

use App\Application\Module\Dto\RequestUpdateModuleDto;
use Illuminate\Foundation\Http\FormRequest;

class ModuleUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
        ];
    }

    public function dto(): RequestUpdateModuleDto
    {
        return new RequestUpdateModuleDto(
            title: $this->string('title')->toString()
        );
    }
}
