<?php
declare(strict_types=1);

namespace App\Application\Module\Commands;

use App\Application\Module\Dto\CreateModuleDto;

interface CreateModuleHandlerInterface
{
    public function handle(int $courseId, CreateModuleDto $dto): int;
}
