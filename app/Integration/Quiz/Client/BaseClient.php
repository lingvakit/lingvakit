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
        $client = Http::withoutVerifying()
            ->baseUrl($this->getMsUrl())
            ->acceptJson();

        $token = config('services.ms.quiz_sync_token');
        if ($token) {
            $client->withToken($token);
        }

        return $client;
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
