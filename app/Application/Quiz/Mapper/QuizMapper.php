<?php
declare(strict_types=1);

namespace App\Application\Quiz\Mapper;

use App\Application\Media\Dto\MediaFileDto;
use App\Application\Media\Mapper\MediaFileMapper;
use App\Infrastructure\Persistence\Repository\MediaFileRepositoryInterface;
use App\Infrastructure\Persistence\Repository\TopicRepositoryInterface;
use App\Integration\Quiz\Dto\QuizDto;
use App\Integration\Quiz\Dto\QuizResponseDto;
use Symfony\Component\Uid\Uuid;

final readonly class QuizMapper
{
    public function __construct(
        private MediaFileMapper $mediaFileMapper,
        private MediaFileRepositoryInterface $mediaFileRepository,
        private TopicRepositoryInterface $topicRepository,
    ) {
    }

    public function fromMsResponse(QuizResponseDto $dto): QuizDto
    {
        return new QuizDto(
            uuid: Uuid::fromString($dto->uuid),
            title: $dto->title,
            description: $dto->description,
            imageFile: $this->getMediaFileDto($dto->imageId),
            audioFile: $this->getMediaFileDto($dto->audioId),
            videoFile: $this->getMediaFileDto($dto->videoId),
            timeLimit: $dto->timeLimit,
            passingScore: $dto->passingScore,
            status: $dto->status,
            orderIndex: $this->getOrderIndex($dto->uuid),
        );
    }

    private function getMediaFileDto(?int $fileId = null): ?MediaFileDto
    {
        if ($fileId === null) {
            return null;
        }

        $mediaFile = $this->mediaFileRepository->findById($fileId);

        return $this->mediaFileMapper->fromModel($mediaFile);
    }

    private function getOrderIndex(string $uuid): ?int
    {
        return $this->topicRepository
            ->findByEntityId($uuid)
            ?->order_index;
    }
}
