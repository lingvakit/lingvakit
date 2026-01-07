<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Quiz\Clients;

use App\Models\LMS\Quiz;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class QuizClient extends BaseMsClient
{
    public function getQuiz(string $uuid): array
    {
        if (empty($uuid)) {
            throw new \RuntimeException('Cannot update quiz in MS: UUID is missing.');
        }

        $url = "{$this->baseUrl}/api/v1/quizzes/$uuid";
        $response = Http::withoutVerifying()
            ->withToken($this->jwtService->getJwtToken())
            ->get($url);

        if ($response->failed()) {
            Log::error($response->body());
            throw new \RuntimeException(
                'Failed to fetch quiz from MS: ' . $response->body()
            );
        }

        return $response->json();
    }

    /**
     * @param array{
     *     uuid?: string|null,
     *     title: string,
     *     description?: string|null,
     *     imageId?: int|null,
     *     videoId?: int|null,
     *     audioId?: int|null,
     *     timeLimit?: int|null,
     *     passingScore: int,
     *     status: string // enum: draft, published or deleted
     * } $data
     *
     * @throws Exception
     */
    public function store(array $data): string
    {
        $url = "{$this->baseUrl}/api/v1/quizzes";
        $response = Http::withoutVerifying()
            ->withToken($this->jwtService->getJwtToken())
            ->post($url, $data);

        if ($response->failed()) {
            Log::error($response->body());
            throw new \RuntimeException(
                'MS Quiz error: ' . $response->body()
            );
        }

        return $response->json()['uuid'];
    }

    public function updateQuiz(Quiz $quiz, array $payload = []): void
    {
        if ($quiz->uuid === null) {
            throw new \RuntimeException('Cannot update quiz in MS: UUID is missing.');
        }

        $url = "{$this->baseUrl}/api/v1/quizzes/{$quiz->uuid}";
        $response = Http::withoutVerifying()
            ->withToken($this->jwtService->getJwtToken())
            ->put($url, $payload);

        if ($response->failed()) {
            Log::error($response->body());
            throw new \RuntimeException(
                'Failed to update quiz in MS: ' . $response->body()
            );
        }
    }

    public function deleteQuiz(Quiz $quiz): void
    {
        if ($quiz->uuid === null) {
            throw new \RuntimeException('Cannot delete quiz in MS: UUID is missing.');
        }

        $url = "{$this->baseUrl}/api/v1/quizzes/{$quiz->uuid}";
        $response = Http::withoutVerifying()
            ->withToken($this->jwtService->getJwtToken())
            ->delete($url);

        if ($response->failed()) {
            Log::error($response->body());
            throw new \RuntimeException(
                'Failed to delete quiz in MS: ' . $response->body()
            );
        }
    }
}
