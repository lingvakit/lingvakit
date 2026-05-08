<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Client;

use App\Integration\Quiz\Exception\QuizClientException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class BaseClient
{
    protected function http(): PendingRequest
    {
        return Http::withoutVerifying()
            ->baseUrl($this->getMsUrl())
            ->acceptJson();
    }

    protected function handleResponse(Response $response, callable $mapper)
    {
        if (!$response->successful()) {
            throw new QuizClientException(
                $response->body(),
                $response->status()
            );
        }

        return $mapper($response->json());
    }

    protected function getMsUrl(): string
    {
        return config('app.url') . config('services.ms.quiz');
    }
}
