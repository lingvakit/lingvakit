<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Quiz;

use App\Application\Quiz\Handlers\QuizDetailsHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Resources\Quiz\QuizDetailsResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QuizDetailsController extends Controller
{
    public function __construct(
        private readonly QuizDetailsHandlerInterface $handler
    ) {}

    public function __invoke(string $quizUuid): JsonResponse
    {
        $quizDto = $this->handler->handle($quizUuid);

        return response()->json(
            data: [
                'data' => new QuizDetailsResource($quizDto)
            ],
            status: Response::HTTP_OK
        );
    }
}