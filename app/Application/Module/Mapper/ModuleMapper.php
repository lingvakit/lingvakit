<?php
declare(strict_types=1);

namespace App\Application\Module\Mapper;

use App\Application\Module\Dto\ModuleDto;
use App\Models\LMS\Stage;

final readonly class ModuleMapper
{
    public function fromModel(Stage $stage): ModuleDto
    {
        return new ModuleDto(
            id: $stage->id,
            title: $stage->name,
            topics: null, // TODO: set actual data
        );
    }
}
