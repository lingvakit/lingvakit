<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Client;

use App\Domain\Quiz\Entity\QuizEntity;
use App\Integration\Quiz\Dto\Request\Quiz\QuizCreateRequestDto;
use App\Integration\Quiz\Dto\Request\Quiz\QuizUpdateRequestDto;
use App\Integration\Quiz\Dto\Response\QuizDto;
use App\Integration\Quiz\Exception\QuizCreateFailedException;
use App\Integration\Quiz\Mapper\QuizMapper;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Uid\Uuid;

class QuizClient extends BaseClient implements QuizServiceInterface
{
    public function __construct(
        private readonly QuizMapper $mapper,
    ) {
    }

    public function getDataByUuid(string $uuid): QuizDto
    {
        if (!$this->validateUuid($uuid)) {
            throw new BadRequestHttpException(
                "UUID [$uuid] is invalid."
            );
        }

        $response = $this->http()->get(
            "{$this->getMsUrl()}/api/v1/quizzes/{$uuid}"
        );

        return $this->handleResponse(
            $response,
            fn(array $responseData) => $this->mapper->fromResponseDataToDto($responseData)
        );
    }

    /**
     * @param string[] $topicEntityIds
     * @return array<string, QuizEntity>
     */
    public function getBatchDataByUuids(array $topicEntityIds): array
    {
        if (empty($topicEntityIds)) {
            return [];
        }

        $response = $this->http()->post(
            url: "{$this->getMsUrl()}/api/v1/quizzes/batch",
            data: ["uuids" => $topicEntityIds],
        );

        return $this->handleResponse(
            $response,
            fn(array $responseData) => $this->mapper->fromResponseDataToDtoArray($responseData)
        );
    }

    public function create(QuizCreateRequestDto $dto): QuizDto
    {
        $response = $this->http()->post(
            url: "{$this->getMsUrl()}/api/v1/quizzes",
            data: $dto->convertToArray()
        );

        return $this->handleResponse(
            $response,
            fn(array $responseData) => $this->mapper->fromResponseDataToDto($responseData)
        );
    }

    public function update(string $uuid, QuizUpdateRequestDto $dto): QuizDto
    {
        if (!Uuid::isValid($uuid)) {
            throw new BadRequestHttpException(
                "UUID [$uuid] is invalid."
            );
        }

        $response = Http::withoutVerifying()->put(
            url: "{$this->getMsUrl()}/api/v1/quizzes/{$uuid}",
            data: $dto->convertToArray()
        );

        if (!$response->successful()) {
            throw new QuizCreateFailedException(
                message: 'Quiz API error: ' . $response->body(),
                code: $response->status()
            );
        }

        return $this->handleResponse(
            $response,
            fn(array $responseData) => $this->mapper->fromResponseDataToDto($responseData)
        );
    }

    private function validateUuid($uuid): bool
    {
        return Uuid::isValid($uuid);
    }
}
