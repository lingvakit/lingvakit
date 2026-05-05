<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\QuestionsGroup;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QuestionsGroupCreateController extends Controller
{
    public function __invoke(QuestionsGroupCreateRequest $request): JsonResponse
    {


        return response()->json(
            data: [
                'data' => new QuestionsGroupResponse('')
            ],
            status: Response::HTTP_CREATED
        );
    }
}
