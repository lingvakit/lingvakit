<?php
declare(strict_types=1);

namespace App\Integration\Media\Client;

use App\Integration\Media\Exception\MediaClientException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class BaseClient
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
            throw new MediaClientException(
                $response->body(),
                $response->status()
            );
        }

        return $mapper($response->json());
    }

    protected function getMsUrl(): string
    {
        return config('app.url') . config('services.ms.media');
    }
}
