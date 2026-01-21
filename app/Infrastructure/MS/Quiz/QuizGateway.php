<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Quiz;

use App\Infrastructure\MS\Quiz\Clients\QuizClient;
use App\Models\LMS\Quiz;
use Exception;
use Symfony\Component\Uid\Uuid;

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

    /**
     * @param array{
     *     id: int,
     *     uuid: string,
     *     title: string,
     *     description: string|null,
     *     image: int|null,
     *     video: int|null,
     *     audio: int|null,
     *     duration: int,
     *     passing_score: int,
     * } $data
     * @return string
     * @throws Exception
     */
    public function storeInMs(array $data): string
    {
        return $this->client->store([
            'uuid' => Uuid::v4()->toRfc4122(),
            'title' => (string)$data['title'],
            'description' => (string)$data['description'] ?? null,
            'imageId' => $data['image'] ?? null,
            'videoId' => $data['video'] ?? null,
            'audioId' => $data['audio'] ?? null,
            'timeLimit' => $data['duration'] ?? null,
            'passingScore' => (int)$data['passing_score'] ?? null,
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
