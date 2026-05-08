<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Client;

use App\Domain\Quiz\Enum\QuizStatusEnum;
use App\Integration\Quiz\Dto\QuizCreateRequestDto;
use App\Integration\Quiz\Dto\QuizResponseDto;
use App\Integration\Quiz\Dto\QuizUpdateRequestDto;
use App\Integration\Quiz\Exception\QuizCreateFailedException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Uid\Uuid;

class QuizClient extends BaseClient implements QuizServiceInterface
{
    public function getDataByUuid(string $uuid): QuizResponseDto
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
            fn(array $data) => $this->mapToDto($data)
        );
    }

    public function create(QuizCreateRequestDto $dto): QuizResponseDto
    {
        $response = $this->http()->post(
            url: "{$this->getMsUrl()}/api/v1/quizzes",
            data: $dto->convertToArray()
        );

        return $this->handleResponse(
            $response,
            fn(array $data) => $this->mapToDto($data)
        );
    }

    public function update(string $uuid, QuizUpdateRequestDto $dto): QuizResponseDto
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

        return $this->mapToDto(
            json_decode($response->body(), true)
        );
    }

    // TODO: Remove after relocate method
    private function mapToDto(array $data): QuizResponseDto
    {
        return new QuizResponseDto(
            uuid: $data['uuid'],
            title: $data['title'],
            description: $data['description'] ?? null,
            imageId: $data['imageId'] ?? null,
            audioId: $data['audioId'] ?? null,
            videoId: $data['videoId'] ?? null,
            timeLimit: $data['timeLimit'],
            passingScore: $data['passingScore'],
            status: QuizStatusEnum::from($data['status']),
        );
    }

    private function validateUuid($uuid): bool
    {
        return Uuid::isValid($uuid);
    }
}
