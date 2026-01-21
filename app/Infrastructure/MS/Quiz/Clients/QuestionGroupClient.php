<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Quiz\Clients;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Uid\Uuid;

final class QuestionGroupClient extends BaseMsClient
{
    public function getData(Uuid $uuid): array
    {
        $url = "{$this->baseUrl}/api/v1/questionGroups/{$uuid->toRfc4122()}";

        $response = Http::withoutVerifying()
            ->withToken($this->jwtService->getJwtToken())
            ->get($url);

        if ($response->failed()) {
            $this->logger->error($response->body());
            throw new RuntimeException(
                'MS Quiz error: ' . $response->body()
            );
        }

        return $response->json();
    }

    /**
     * @param array{
     *     quizUuid: string,
     *     title: string,
     *     questionType: string, // QuestionType enum from MS Quiz
     *     uuid?: string|null,
     *     description?: string|null,
     *     orderIndex?: int|null,
     *     media?: array|null,
     *     meta?: array|null,
     *     questions?: array|null
     *  } $payload
     *
     * @return string UUID of created question group
     * @throws Exception
     */
    public function store(array $payload): string
    {
        $url = "{$this->baseUrl}/api/v1/questionGroups";

        $response = Http::withoutVerifying()
            ->withToken($this->jwtService->getJwtToken())
            ->post($url, $payload);

        if ($response->failed()) {
            $this->logger->error($response->body());
            throw new RuntimeException(
                'MS Quiz error: ' . $response->body()
            );
        }

        return $response->json()['uuid'];
    }

    /**
     * @param Uuid $uuid
     * @param array{
     *     title?: string,
     *     questionType?: string,
     *     description?: string|null,
     *     orderIndex?: int|null,
     *     meta?: array|null,
     * } $payload
     * @return void
     */
    public function update(string $uuid, array $payload = []): void
    {
        $url = "{$this->baseUrl}/api/v1/questionGroups/{$uuid}";

        $response = Http::withoutVerifying()
            ->withToken($this->jwtService->getJwtToken())
            ->put($url, $payload);

        if ($response->failed()) {
            Log::error($response->body());
            throw new \RuntimeException(
                'Failed to update question group in MS: ' . $response->body()
            );
        }
    }
}