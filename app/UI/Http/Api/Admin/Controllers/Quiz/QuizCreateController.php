<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Quiz;

use App\Application\Quiz\Handlers\CreateQuizHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Quiz\QuizCreateRequest;
use App\UI\Http\Api\Admin\Resources\Quiz\QuizDetailsResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QuizCreateController extends Controller
{
    public function __construct(
        private readonly CreateQuizHandlerInterface $handler
    ) {
    }

    public function __invoke(QuizCreateRequest $request): JsonResponse
    {
        $quizDto = $this->handler->handle(
            $request->dto()
        );

        return response()->json(
            data: [
                'data' => new QuizDetailsResource($quizDto)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
