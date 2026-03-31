<?php
declare(strict_types=1);

namespace App\Application\Module\Commands;

use App\Application\Module\Dto\RequestModuleDto;
use App\Exceptions\ModuleNotExistsException;
use App\Infrastructure\Persistence\Repository\ModuleRepository;
use App\Models\LMS\Stage;

final readonly class UpdateModuleHandler implements UpdateModuleHandlerInterface
{
    public function __construct(
        private ModuleRepository $repository,
    ) {}

    /**
     * @throws ModuleNotExistsException
     */
    public function handle(int $moduleId, RequestModuleDto $dto): int
    {
        $module = Stage::find($moduleId);
        if ($module === null) {
            throw new ModuleNotExistsException("Module with id $moduleId not found");
        }

        return $this->repository->update($module, $dto);
    }
}
