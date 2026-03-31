<?php
declare(strict_types=1);

namespace App\Application\Module\Commands;

use App\Application\Module\Dto\RequestModuleDto;
use App\Models\LMS\Stage;

interface CreateModuleHandlerInterface
{
    public function handle(int $courseId, RequestModuleDto $dto): Stage;
}
