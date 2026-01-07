<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Quiz;

use App\Infrastructure\MS\Quiz\Clients\QuestionClient;
use Exception;
use Symfony\Component\Uid\Uuid;

class QuestionGateway
{
    public function __construct(
        private readonly QuestionClient $client
    ) {
    }

    /**
     * @param array{
     *     groupUuid: string,
     *     title: string,
     *     imageId?: int|null,
     *     audioId?: int|null,
     *     wordNumber: int|null,
     *     points?: int|null,
     *     type: string|null,
     *     answer: array,
     *     options: array
     * } $data
     *
     * @return string Returns the UUID of the created question group
     * @throws Exception
     */
    public function storeInMs(array $data): string
    {
        return $this->client->store([
            'uuid' => Uuid::v4()->toRfc4122(),
            'groupUuid' => (string)$data['groupUuid'],
            'text' => (string)$data['title'],
            'type' => (string)$data['type'],
            'explanation' => null,
            'points' => $data['points'],
            'orderIndex' => null,
            'settings' => $this->getSettings($data),
            'answer' => (array)$data['answer'],
            'options' => (array)$data['options'],
        ]);
    }

    private function getSettings(array $data): ?array
    {
        $settings = [];

        if ($data['imageId']) {
            $settings['media'][] = [
                'id' => $data['imageId'],
                'type' => 'image',
            ];
        }

        if ($data['audioId']) {
            $settings['media'][] = [
                'id' => $data['audioId'],
                'type' => 'audio',
            ];
        }

        return !empty($settings) ? $settings : null;
    }
}