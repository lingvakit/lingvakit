<?php
declare(strict_types=1);

namespace App\Application\Quiz\Mapper;

use App\Application\Media\Dto\MediaFileDto;
use App\Application\Media\Mapper\MediaFileMapper;
use App\Application\Quiz\Dto\Response\QuizDto;
use App\Infrastructure\Persistence\Repository\MediaFileRepositoryInterface;
use App\Infrastructure\Persistence\Repository\TopicRepositoryInterface;
use App\Integration\Quiz\Dto\Response\QuestionDto;
use App\Integration\Quiz\Dto\Response\QuestionOptionDto;
use App\Integration\Quiz\Dto\Response\QuestionsGroupDto;
use App\Integration\Quiz\Dto\Response\QuizDto as QuizMsDto;
use Symfony\Component\Uid\Uuid;

final readonly class QuizMapper
{
    public function __construct(
        private MediaFileMapper $mediaFileMapper,
        private MediaFileRepositoryInterface $mediaFileRepository,
        private TopicRepositoryInterface $topicRepository,
    ) {
    }

    public function fromMsResponse(QuizMsDto $dto): QuizDto
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
            questionGroups: array_map(
                fn($group) => new QuestionsGroupDto(
                    uuid: $group->uuid,
                    title: $group->title,
                    description: $group->description,
                    questionType: $group->questionType,
                    orderIndex: $group->orderIndex,
                    media: $group->mediaFiles ?? null,
                    meta: $group->meta ?? null,
                    questions: array_map(
                        fn($question) => new QuestionDto(
                            uuid: $question->uuid,
                            text: $question->text,
                            type: $question->type,
                            explanation: $question->explanation ?? null,
                            points: $question->points,
                            orderIndex: $question->orderIndex,
                            settings: $question->settings ?? null,
                            answer: $question->answer,
                            options: array_map(
                                fn($option) => new QuestionOptionDto(
                                    uuid: $option->uuid,
                                    text: $option->text ?? null,
                                    matchKey: $option->matchKey ?? null,
                                    orderIndex: $option->orderIndex ?? null,
                                    settings: $option->setting ?? null,
                                ),
                                $question->options ?? []
                            ),
                        ),
                        $group->questions ?? []
                    ),
                ),
                $dto->questionGroups
            ),
        );
    }

    private function getMediaFileDto(?int $fileId = null): ?MediaFileDto
    {
        if ($fileId === null) {
            return null;
        }

        $mediaFile = $this->mediaFileRepository->findById($fileId);
        if ($mediaFile === null) {
            return null;
        }

        return $this->mediaFileMapper->fromModel($mediaFile);
    }

    private function getOrderIndex(string $uuid): ?int
    {
        return $this->topicRepository
            ->findByEntityId($uuid)
            ?->order_index;
    }
}
