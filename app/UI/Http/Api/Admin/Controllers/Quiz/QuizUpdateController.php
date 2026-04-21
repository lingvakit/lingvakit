<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Quiz;

use App\Application\Quiz\Handlers\UpdateQuizHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Quiz\QuizUpdateRequest;
use App\UI\Http\Api\Admin\Resources\Quiz\QuizDetailsResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QuizUpdateController extends Controller
{
    public function __construct(
        private readonly UpdateQuizHandlerInterface $handler
    ) {
    }

    public function __invoke(
        QuizUpdateRequest $request,
        string $uuid
    ): JsonResponse {
        $quiz = $this->handler->handle($uuid, $request->dto());

        return response()->json(
            data: [
                'data' => new QuizDetailsResource($quiz)
            ],
            status: Response::HTTP_OK
        );
    }
}
