<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Auth\Controllers;

use App\Application\User\Actions\RegisterUser;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Auth\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, RegisterUser $registerUser): JsonResponse
    {
        if (! $request->isBot()) {
            $registerUser($request->toDto());
        }

        return new JsonResponse(
            data: ['message' => 'Ссылка для создания пароля отправлена на ваш email.'],
            status: Response::HTTP_CREATED
        );
    }
}
