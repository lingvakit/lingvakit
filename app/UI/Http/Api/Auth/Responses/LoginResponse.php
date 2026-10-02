<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Auth\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

final class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): JsonResponse|RedirectResponse
    {
        $url = redirect()->intended(config('fortify.home'))->getTargetUrl();

        return $request->wantsJson()
            ? new JsonResponse([
                'two_factor' => false,
                'redirect' => $url
            ]) : redirect($url);
    }
}
