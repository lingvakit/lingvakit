<?php
declare(strict_types=1);

namespace App\Application\Module\Commands;

use App\Application\Module\Dto\ModuleDto;
use App\Application\Module\Dto\RequestCreateModuleDto;

interface ShowModuleHandlerInterface
{
    public function handle(int $moduleId): ModuleDto;
}
