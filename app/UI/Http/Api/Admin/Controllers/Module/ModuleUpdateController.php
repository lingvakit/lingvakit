<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Module;

use App\Application\Module\Handlers\UpdateModuleHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Module\ModuleUpdateRequest;
use App\UI\Http\Api\Admin\Resources\Module\ModuleDetailsResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ModuleUpdateController extends Controller
{
    public function __construct(
        private readonly UpdateModuleHandlerInterface $handler
    ) {
    }

    public function __invoke(
        ModuleUpdateRequest $request,
        int $moduleId
    ): JsonResponse {
        $module = $this->handler->handle(
            $moduleId, $request->dto()
        );

        return response()->json(
            data: [
                'data' => new ModuleDetailsResource($module)
            ],
            status: Response::HTTP_OK
        );
    }
}
