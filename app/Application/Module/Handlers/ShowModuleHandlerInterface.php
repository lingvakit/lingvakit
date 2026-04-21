<?php
declare(strict_types=1);

namespace App\Application\Module\Handlers;

use App\Application\Module\Dto\ModuleDto;

interface ShowModuleHandlerInterface
{
    public function handle(int $moduleId): ModuleDto;
}
