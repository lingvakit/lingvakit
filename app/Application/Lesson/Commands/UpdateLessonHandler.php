<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

use App\Application\Lesson\Dto\LessonDto;
use App\Application\Lesson\Dto\LessonUpdateRequestDto;
use App\Exceptions\LessonNotExistsException;
use App\Infrastructure\Persistence\Repository\LessonRepositoryInterface;
use App\Infrastructure\Persistence\Repository\TopicRepositoryInterface;
use Illuminate\Support\Facades\DB;

final readonly class UpdateLessonHandler implements UpdateLessonHandlerInterface
{
    public function __construct(
        private TopicRepositoryInterface $topicRepository,
        private LessonRepositoryInterface $lessonRepository,
    ) {
    }

    public function handle(int $lessonId, LessonUpdateRequestDto $dto): LessonDto
    {
        return DB::transaction(function () use ($lessonId, $dto) {
            $lesson = $this->lessonRepository->findById($lessonId);

            if ($lesson === null) {
                throw new LessonNotExistsException(
                    message: "Lesson with id {$lessonId} not found"
                );
            }

            $topic = $this->topicRepository->update(
                topic: $lesson->topic,
                data: [
                    'index_number' => $dto->orderIndex,
                    'stage_id' => $dto->moduleId ?: $lesson->topic->stage_id,
                    'passed_topics' => null // TODO: Set actual data
                ]
            );

            $this->lessonRepository->update(
                lesson: $lesson,
                data: [
                    'title' => $dto->title,
                    'description' => $dto->description,
                    'duration' => $dto->duration,
                    'image' => $dto->imageMediaId,
                    'audio' => $dto->audioMediaId,
                    'video' => $dto->videoMediaId,
                ]
            );

            return new LessonDto(
                id: $lesson->id,
                title: $lesson->title,
                duration: (int)$lesson->duration,
                description: $lesson->description,
                imageUrl: $lesson->getImage(),
                audioUrl: $lesson->getAudio(),
                videoUrl: $lesson->getVideo(),
                orderIndex: $topic->index_number,
            );
        });
    }
}
