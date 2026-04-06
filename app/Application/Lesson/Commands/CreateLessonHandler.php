<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

use App\Application\Course\Enum\TopicTypeEnum;
use App\Application\Lesson\Dto\LessonCreateRequestDto;
use App\Application\Lesson\Dto\LessonDto;
use App\Infrastructure\Persistence\Repository\LessonRepositoryInterface;
use App\Infrastructure\Persistence\Repository\TopicRepositoryInterface;
use Illuminate\Support\Facades\DB;

final readonly class CreateLessonHandler implements CreateLessonHandlerInterface
{
    public function __construct(
        private TopicRepositoryInterface $topicRepository,
        private LessonRepositoryInterface $lessonRepository,
    ) {
    }

    public function handle(LessonCreateRequestDto $dto): LessonDto
    {
        return DB::transaction(function () use ($dto) {
            $topic = $this->topicRepository->save([
                'index_number' => null,
                'name' => TopicTypeEnum::Lesson->value,
                'stage_id' => $dto->moduleId,
                'passed_topics' => null
            ]);

            $lesson = $this->lessonRepository->save([
                'title' => $dto->title,
                'description' => $dto->description,
                'image' => $dto->imageMediaId,
                'audio' => $dto->audioMediaId,
                'video' => $dto->videoMediaId,
                'duration' => $dto->duration,
                'topic_id' => $topic->id
            ]);

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
