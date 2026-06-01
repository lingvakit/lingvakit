<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\MediaFile;

use App\Application\Media\Dto\MediaFileCreateRequestDto;
use App\UI\Http\Api\Admin\Requests\AbstractFormRequest;

class MediaFileRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'file' => ['required', 'file'],
            'title' => ['nullable', 'string', 'max:255'],
            'altText' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function dto(): MediaFileCreateRequestDto
    {
        return new MediaFileCreateRequestDto(
            title: $this->fieldString('title'),
            altText: $this->fieldString('altText'),
        );
    }
}
