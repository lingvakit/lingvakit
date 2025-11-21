<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Quiz;

use App\Models\LMS\Quiz;

class QuizGateway
{
    private const string STATUS_DRAFT = 'draft';

    public function __construct(
        private readonly QuizClient $client
    ) {
    }

    public function getQuizDataFromMs(string $uuid): array
    {
        return $this->client->getQuiz($uuid);
    }

    public function createQuizInMs(array $data): string
    {
        return $this->client->createQuiz([
            'title' => $data['title'],
            'description' => $data['description'],
            'imageId' => $data['image'] ?? null,
            'videoId' => $data['video'] ?? null,
            'audioId' => $data['audio'] ?? null,
            'timeLimit' => $data['duration'],
            'passingScore' => $data['passing_score'],
            'status' => self::STATUS_DRAFT,
        ]);
    }

    public function updateQuizInMs(array $data, Quiz $quiz): void
    {
        $this->client->updateQuiz($quiz, [
            'title' => $data['title'],
            'description' => $data['description'],
            'imageId' => $data['image'] ?? null,
            'videoId' => $data['video'] ?? null,
            'audioId' => $data['audio'] ?? null,
            'timeLimit' => $data['duration'],
            'passingScore' => $data['passing_score'],
            'status' => self::STATUS_DRAFT,
        ]);
    }

    public function deleteQuizFromMs(Quiz $quiz): void
    {
        $this->client->deleteQuiz($quiz);
    }
}
