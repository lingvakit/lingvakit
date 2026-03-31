<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\Module;

use App\Application\Module\Dto\RequestModuleDto;
use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
        ];
    }

    public function dto(): RequestModuleDto
    {
        return new RequestModuleDto(
            title: $this->string('title')->toString()
        );
    }
}
