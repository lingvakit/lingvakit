<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Quiz;

use App\Models\LMS\Quiz;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

readonly class QuizClient
{
    public function __construct(
        private string $baseUrl,
        private string $token,
    ) {}

    public function getQuiz(string $uuid): array
    {
        if (empty($uuid)) {
            throw new \RuntimeException('Cannot update quiz in MS: UUID is missing.');
        }

        $url = "{$this->baseUrl}/api/v1/quizzes/$uuid";
        $response = Http::withoutVerifying()->withToken($this->token)->get($url);

        if ($response->failed()) {
            Log::error($response->body());
            throw new \RuntimeException(
                'Failed to fetch quiz from MS: ' . $response->body()
            );
        }

        return $response->json();
    }

    public function createQuiz(array $payload): string
    {
        $url = "{$this->baseUrl}/api/v1/quizzes";
        $response = Http::withoutVerifying()->withToken($this->token)->post($url, $payload);

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
        $response = Http::withoutVerifying()->withToken($this->token)->put($url, $payload);

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
        $response = Http::withoutVerifying()->withToken($this->token)->delete($url);

        if ($response->failed()) {
            Log::error($response->body());
            throw new \RuntimeException(
                'Failed to delete quiz in MS: ' . $response->body()
            );
        }
    }
}
