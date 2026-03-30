<?php
declare(strict_types=1);

namespace App\Application\Module\Commands;

use App\Application\Module\Dto\CreateModuleDto;
use App\Infrastructure\Persistence\Repository\ModuleRepository;

final readonly class CreateModuleHandler implements CreateModuleHandlerInterface
{
    public function __construct(
        private ModuleRepository $repository,
    ) {}

    public function handle(int $courseId,CreateModuleDto $dto): int
    {
        return $this->repository->create($courseId, $dto);
    }
}
