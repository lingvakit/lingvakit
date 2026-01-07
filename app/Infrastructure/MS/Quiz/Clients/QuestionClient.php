<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Quiz\Clients;

use Exception;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final class QuestionClient extends BaseMsClient
{
    /**
     * @param array{
     *     uuid?: string|null,
     *     groupUuid: string,
     *     text: string,
     *     type: string, // QuestionType enum from MS Quiz
     *     explanation?: string|null,
     *     points?: int|null,
     *     orderIndex?: int|null,
     *     settings?: array|null,
     *     answer?: array|null,
     *     options?: array|null
     *  } $data
     *
     * @return string UUID of created question
     * @throws Exception
     */
    public function store(array $data): string
    {
        $url = "{$this->baseUrl}/api/v1/questions";

        $response = Http::withoutVerifying()
            ->withToken($this->jwtService->getJwtToken())
            ->post($url, $data);

        if ($response->failed()) {
            $this->logger->error($response->body());
            throw new RuntimeException(
                'MS Quiz error: ' . $response->body()
            );
        }

        return $response->json()['uuid'];
    }
}