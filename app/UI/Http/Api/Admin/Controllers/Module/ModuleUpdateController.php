<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Module;

use App\Application\Module\Handlers\UpdateModuleHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Module\ModuleUpdateRequest;
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
        $module = $this->handler->handle($moduleId, $request->dto());

        return response()->json(
            data: ['data' => [
                "message" => "Module with id: {$module->id} successfully updated."
            ]],
            status: Response::HTTP_OK
        );
    }
}
