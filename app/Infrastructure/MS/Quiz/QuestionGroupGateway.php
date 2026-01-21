<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Quiz;

use App\Application\Quiz\Enum\MediaType;
use App\Infrastructure\MS\Quiz\Clients\QuestionGroupClient;
use Exception;
use Symfony\Component\Uid\Uuid;

readonly class QuestionGroupGateway
{
    public function __construct(
        private QuestionGroupClient $client
    ) {
    }

    public function getDataFromMs(Uuid $uuid): array
    {
        return $this->client->getData($uuid);
    }

    /**
     * @param array{
     *     quizUuid: string,
     *     title: string,
     *     imageId: int|null,
     *     type: string,
     *     description: string|null,
     *     fontSize: string|null, // small, normal or large
     *     questions?: array|null
     * } $data
     *
     * @return string Returns the UUID of the created question group
     * @throws Exception
     */
    public function storeInMs(array $data): string
    {
        return $this->client->store([
            'quizUuid' => (string)$data['quizUuid'],
            'uuid' => Uuid::v4()->toRfc4122(),
            'title' => (string)$data['title'],
            'questionType' => (string)$data['type'],
            'description' => $data['description'] ?? null,
            'orderIndex' => null,
            'media' => $this->getMedia($data),
            'meta' => $this->getMeta($data),
            'questions' => $data['questions'] ?? null,
        ]);
    }

    public function updateInMs(string $uuid, array $data = []): void
    {
        $this->client->update(
            uuid: $uuid,
            payload: $data
        );
    }

    private function getMedia(array $data): ?array
    {
        $media = [];

        if ($data['imageId']) {
            $media[] = [
                'type' => MediaType::Image->value,
                'mediaId' => $data['imageId'],
            ];
        }

        return !empty($media) ? $media : null;
    }

    private function getMeta(array $data): ?array
    {
        $meta = [];

        if ($data['fontSize']) {
            $meta['style']['fontSize'] = $data['fontSize'];
        }

        return !empty($meta) ? $meta : null;
    }
}