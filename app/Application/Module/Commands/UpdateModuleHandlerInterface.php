<?php
declare(strict_types=1);

namespace App\Application\Module\Commands;

use App\Application\Module\Dto\ModuleDto;
use App\Application\Module\Dto\RequestUpdateModuleDto;

interface UpdateModuleHandlerInterface
{
    public function handle(int $moduleId, RequestUpdateModuleDto $dto): ModuleDto;
}
