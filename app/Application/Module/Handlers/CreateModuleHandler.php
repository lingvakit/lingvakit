<?php
declare(strict_types=1);

namespace App\Application\Module\Handlers;

use App\Application\Module\Dto\ModuleDto;
use App\Application\Module\Dto\RequestCreateModuleDto;
use App\Application\Module\Mapper\ModuleMapper;
use App\Infrastructure\Persistence\Repository\ModuleRepositoryInterface;

final readonly class CreateModuleHandler implements CreateModuleHandlerInterface
{
    public function __construct(
        private ModuleRepositoryInterface $repository,
        private ModuleMapper $mapper
    ) {}

    public function handle(RequestCreateModuleDto $dto): ModuleDto
    {
        $stage = $this->repository->save($dto->toArray());

        return $this->mapper->fromStageSummary($stage);
    }
}
