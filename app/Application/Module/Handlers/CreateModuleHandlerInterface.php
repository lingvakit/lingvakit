<?php
declare(strict_types=1);

namespace App\Application\Module\Handlers;

use App\Application\Module\Dto\ModuleDto;
use App\Application\Module\Dto\RequestCreateModuleDto;

interface CreateModuleHandlerInterface
{
    public function handle(RequestCreateModuleDto $dto): ModuleDto;
}
