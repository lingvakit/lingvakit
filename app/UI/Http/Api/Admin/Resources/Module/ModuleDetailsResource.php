<?php
declare (strict_types=1);

namespace App\UI\Http\Api\Admin\Resources\Module;

use App\Application\Course\Dto\Course\CourseModuleDto;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var CourseModuleDto $this */
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'topics' => $this->getTopics(),
        ];
    }
}
