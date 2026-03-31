<?php

namespace App\UI\Http\Api\Admin\Controllers\Module;

use App\Application\Module\Commands\CreateModuleHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Module\ModuleRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ModuleCreateController extends Controller
{
    public function __construct(
        private readonly CreateModuleHandlerInterface $handler
    ) {}

    public function __invoke(
        ModuleRequest $request,
        string $courseId
    ): JsonResponse {
        $id = $this->handler->handle(
            $courseId,
            $request->dto()
        );

        return response()->json(
            data: ['data' => ['id' => $id]],
            status: Response::HTTP_CREATED
        );
    }
}
