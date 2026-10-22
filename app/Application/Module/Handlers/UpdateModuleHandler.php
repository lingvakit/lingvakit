<?php
declare(strict_types=1);

namespace App\Application\Module\Handlers;

use App\Application\Module\Dto\ModuleDto;
use App\Application\Module\Dto\RequestUpdateModuleDto;
use App\Application\Module\Mapper\ModuleMapper;
use App\Exceptions\ModuleNotExistsException;
use App\Infrastructure\Persistence\Repository\ModuleRepositoryInterface;

final readonly class UpdateModuleHandler implements UpdateModuleHandlerInterface
{
    public function __construct(
        private ModuleRepositoryInterface $repository,
        private ModuleMapper $mapper,
    ) {
    }

    public function handle(int $moduleId, RequestUpdateModuleDto $dto): ModuleDto
    {
        $stage = $this->repository->findById($moduleId)
            ?? throw new ModuleNotExistsException(
                message: "Stage with id {$moduleId} not found"
            );

        $updated = $this->repository->update($stage, $dto->toArray());

        return $this->mapper->fromStageSummary($updated);
    }
}
