<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Auth\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Symfony\Component\HttpFoundation\Response;

final class NeutralPasswordResetLinkResponse implements FailedPasswordResetLinkRequestResponse
{
    public function __construct(
        private readonly string $status
    ) {}

    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: ['message' => 'ok'],
            status: Response::HTTP_OK,
        );
    }
}
