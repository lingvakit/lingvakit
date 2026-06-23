<?php
declare(strict_types=1);

namespace App\Application\Lesson\Handlers;

use App\Application\Lesson\Dto\LessonCreateRequestDto;
use App\Application\Lesson\Dto\LessonDto;
use App\Application\Lesson\Mapper\LessonMapper;
use App\Domain\Lesson\Entity\LessonEntity;
use App\Domain\Lesson\Repository\LessonRepositoryInterface;
use App\Domain\Quiz\ValueObject\MediaFile\AudioFileVO;
use App\Domain\Quiz\ValueObject\MediaFile\ImageFileVO;
use App\Domain\Quiz\ValueObject\MediaFile\VideoFileVO;
use App\Domain\Topic\Entity\TopicEntity;
use App\Domain\Topic\Enum\TopicTypeEnum;
use App\Domain\Topic\Repository\TopicRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Database\DatabaseManager;

final readonly class CreateLessonHandler implements CreateLessonHandlerInterface
{
    public function __construct(
        private DatabaseManager $db,
        private TopicRepositoryInterface $topicRepository,
        private LessonRepositoryInterface $lessonRepository,
        private LessonMapper $lessonMapper,
    ) {
    }

    public function handle(LessonCreateRequestDto $dto): LessonDto
    {
        return $this->db->transaction(function () use ($dto) {
            $topicEntity = $this->topicRepository->save(
                $this->prepareTopicEntity($dto)
            );

            $preparedLessonEntity = $this->prepareLessonEntity(
                dto: $dto,
                topicId: $topicEntity->getId()
            );

            $lessonEntity = $this->lessonRepository->save($preparedLessonEntity);
            
            return $this->lessonMapper->fromEntity($lessonEntity, $topicEntity);
        });
    }

    private function prepareTopicEntity(LessonCreateRequestDto $dto): TopicEntity
    {
        return new TopicEntity(
            id: null,
            entityId: null,
            orderIndex: $dto->orderIndex,
            type: TopicTypeEnum::Lesson,
            moduleId: $dto->moduleId,
            passedTopics: $dto->passedTopics,
        );
    }

    private function prepareLessonEntity(
        LessonCreateRequestDto $dto,
        int $topicId
    ): LessonEntity {
        $lessonEntity = new LessonEntity(
            id: null,
            title: $dto->title,
            description: $dto->description,
            duration: $dto->duration,
            topicId: $topicId,
            createdAt: new DateTimeImmutable(),
        );

        if ($dto->imageMediaId) {
            $lessonEntity->addMedia(
                new ImageFileVO($dto->imageMediaId)
            );
        }

        if ($dto->audioMediaId) {
            $lessonEntity->addMedia(
                new AudioFileVO($dto->audioMediaId)
            );
        }

        if ($dto->videoMediaId) {
            $lessonEntity->addMedia(
                new VideoFileVO($dto->videoMediaId)
            );
        }

        return $lessonEntity;
    }
}
