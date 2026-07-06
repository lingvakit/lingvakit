<?php
declare(strict_types=1);

namespace App\Application\Lesson\Handlers;

use App\Application\Lesson\Dto\LessonDto;
use App\Application\Lesson\Dto\LessonUpdateRequestDto;
use App\Application\Lesson\Mapper\LessonMapper;
use App\Domain\Lesson\Entity\LessonEntity;
use App\Domain\Lesson\Repository\LessonRepositoryInterface;
use App\Domain\Quiz\ValueObject\MediaFile\AudioFileVO;
use App\Domain\Quiz\ValueObject\MediaFile\ImageFileVO;
use App\Domain\Quiz\ValueObject\MediaFile\VideoFileVO;
use App\Domain\Topic\Entity\TopicEntity;
use App\Domain\Topic\Repository\TopicRepositoryInterface;
use App\Exceptions\LessonNotExistsException;
use Illuminate\Database\DatabaseManager;

final readonly class UpdateLessonHandler implements UpdateLessonHandlerInterface
{
    public function __construct(
        private DatabaseManager $db,
        private TopicRepositoryInterface $topicRepository,
        private LessonRepositoryInterface $lessonRepository,
        private LessonMapper $lessonMapper,
    ) {
    }

    public function handle(int $lessonId, LessonUpdateRequestDto $dto): LessonDto
    {
        return $this->db->transaction(function () use ($lessonId, $dto) {
            $lesson = $this->lessonRepository->findById($lessonId);

            if ($lesson === null) {
                throw new LessonNotExistsException(
                    message: "Lesson with id {$lessonId} not found"
                );
            }

            $updatedLesson = $this->updateLesson($lesson, $dto);

            $topic = $this->topicRepository->findById($lesson->getTopicId());
            $this->updateTopic($topic, $dto);

            return $this->lessonMapper->fromEntity($updatedLesson, $topic);
        });
    }

    private function updateLesson(
        LessonEntity $entity,
        LessonUpdateRequestDto $dto
    ): LessonEntity {
        $entity
            ->setTitle($dto->title ?? $entity->getTitle())
            ->setDescription($dto->description ?? $entity->getDescription())
            ->setDuration($dto->duration ?? $entity->getDuration())
            ->unsetMedia();

        if ($dto->imageMediaId) {
            $entity->addMedia(
                new ImageFileVO($dto->imageMediaId)
            );
        }

        if ($dto->audioMediaId) {
            $entity->addMedia(
                new AudioFileVO($dto->audioMediaId)
            );
        }

        if ($dto->videoMediaId) {
            $entity->addMedia(
                new VideoFileVO($dto->videoMediaId)
            );
        }

        return $this->lessonRepository->update($entity);
    }

    private function updateTopic(
        TopicEntity $entity,
        LessonUpdateRequestDto $dto
    ): void {
        $entity
            ->setOrderIndex($dto->orderIndex ?? $entity->getOrderIndex())
            ->setPassedTopics($dto->passedTopics ?? $entity->getPassedTopics());

        $this->topicRepository->update($entity);
    }
}
