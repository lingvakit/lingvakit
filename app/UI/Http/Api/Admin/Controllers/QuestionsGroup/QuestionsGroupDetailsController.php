<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\QuestionsGroup;

use App\Application\Quiz\Handlers\QuestionsGroup\QuestionsGroupDetailsHandlerInterface;
use App\UI\Http\Api\Admin\Resources\Quiz\QuestionsGroupResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QuestionsGroupDetailsController
{
    public function __construct(
        private readonly QuestionsGroupDetailsHandlerInterface $handler
    ) {}

    public function __invoke(string $groupUuid): JsonResponse
    {
        $quizDto = $this->handler->handle($groupUuid);

        return response()->json(
            data: new QuestionsGroupResource($quizDto),
            status: Response::HTTP_OK
        );
    }
}
