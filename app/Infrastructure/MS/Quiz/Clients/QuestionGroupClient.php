<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Quiz\Clients;

use Exception;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final class QuestionGroupClient extends BaseMsClient
{
    /**
     * @param array{
     *     quizUuid: string,
     *     title: string,
     *     questionType: string, // QuestionType enum from MS Quiz
     *     description?: string|null,
     *     orderIndex?: int|null,
     *     meta?: array|null,
     *     questions?: array|null
     *  } $data
     *
     * @return string UUID of created question group
     * @throws Exception
     */
    public function store(array $data): string
    {
        $url = "{$this->baseUrl}/api/v1/questionGroups";

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