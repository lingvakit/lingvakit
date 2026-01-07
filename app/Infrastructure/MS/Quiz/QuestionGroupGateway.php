<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Quiz;

use App\Infrastructure\MS\Quiz\Clients\QuestionGroupClient;
use Exception;

readonly class QuestionGroupGateway
{
    public function __construct(
        private QuestionGroupClient $client
    ) {
    }

    /**
     * @param array{
     *     quizUuid: string,
     *     title: string,
     *     imageId: int|null,
     *     type: string,
     *     description: string|null,
     *     fontSize: string|null, // small, normal or large
     * } $data
     *
     * @return string Returns the UUID of the created question group
     * @throws Exception
     */
    public function storeInMs(array $data): string
    {
        return $this->client->store([
            'quizUuid' => (string)$data['quizUuid'],
            'title' => (string)$data['title'],
            'questionType' => (string)$data['type'],
            'description' => $data['description'] ?? null,
            'orderIndex' => null,
            'meta' => $this->getMeta($data),
            'questions' => null
        ]);
    }

    private function getMeta(array $data): ?array
    {
        $meta = [];

        if ($data['imageId']) {
            $meta['media'][] = [
                'id' => $data['imageId'],
                'type' => 'image',
            ];
        }

        if ($data['fontSize']) {
            $meta['style']['fontSize'] = $data['fontSize'];
        }

        return !empty($meta) ? $meta : null;
    }
}