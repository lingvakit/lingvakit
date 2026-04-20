<?php
declare(strict_types=1);

namespace App\Integration\Quiz;

use App\Domain\Quiz\Enum\QuizStatusEnum;
use App\Integration\Quiz\Dto\QuizCreateRequestDto;
use App\Integration\Quiz\Dto\QuizResponseDto;
use App\Integration\Quiz\Exception\QuizCreateFailedException;
use App\Integration\Quiz\Exception\QuizDataFailedException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Uid\Uuid;

class QuizClient implements QuizServiceInterface
{
    public function getDataByUuid(string $uuid): QuizResponseDto
    {
        if (!$this->validateUuid($uuid)) {
            throw new BadRequestHttpException(
                "UUID [$uuid] is invalid."
            );
        }

        $response = Http::withoutVerifying()->get(
            "{$this->getMsUrl()}/api/v1/quizzes/{$uuid}",
        );

        if (!$response->successful()) {
            throw new QuizDataFailedException(
                message: 'Quiz API error: ' . $response->body(),
                code: $response->status()
            );
        }

        return $this->mapToDto(
            json_decode($response->body(), true)
        );
    }

    public function create(QuizCreateRequestDto $dto): QuizResponseDto
    {
        $response = Http::withoutVerifying()->post(
            url: "{$this->getMsUrl()}/api/v1/quizzes",
            data: $dto->convertToArray()
        );

        if (!$response->successful()) {
            throw new QuizCreateFailedException(
                message: 'Quiz API error: ' . $response->body(),
                code: $response->status()
            );
        }

        return $this->mapToDto(json_decode($response->body(), true));
    }

    private function getMsUrl(): string
    {
        return config('app.url') . config('services.ms.quiz');
    }

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
