<?php
declare(strict_types=1);

namespace App\Application\Module\Handlers;

use App\Application\Module\Dto\ModuleDto;
use App\Application\Module\Dto\RequestUpdateModuleDto;
use App\Application\Module\Mapper\ModuleMapper;
use App\Exceptions\ModuleNotExistsException;
use App\Infrastructure\Persistence\Repository\ModuleRepositoryInterface;
use Illuminate\Support\Facades\DB;

final readonly class UpdateModuleHandler implements UpdateModuleHandlerInterface
{
    public function __construct(
        private ModuleRepositoryInterface $repository,
        private ModuleMapper $mapper
    ) {}

    public function handle(int $moduleId, RequestUpdateModuleDto $dto): ModuleDto
    {
        return DB::transaction(function () use ($moduleId, $dto) {
            $stage = $this->repository->findById($moduleId);

            if ($stage === null) {
                throw new ModuleNotExistsException(
                    message: "Stage with id {$moduleId} not found"
                );
            }

            $this->repository->update(
                stage: $stage,
                data: $dto->toArray()
            );

            return $this->mapper->fromModel($stage);
        });
    }
}
