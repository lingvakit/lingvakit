<?php
declare(strict_types=1);

namespace App\Application\Module\Commands;

use App\Application\Module\Dto\RequestModuleDto;

interface UpdateModuleHandlerInterface
{
    public function handle(int $moduleId, RequestModuleDto $dto): int;
}
