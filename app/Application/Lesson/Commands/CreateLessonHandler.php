<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

use App\Application\Lesson\Dto\LessonCreateRequestDto;
use App\Application\Lesson\Dto\LessonDto;
use App\Application\Lesson\Mapper\LessonMapper;
use App\Infrastructure\Persistence\Repository\LessonRepositoryInterface;
use App\Infrastructure\Persistence\Repository\TopicRepositoryInterface;
use Illuminate\Support\Facades\DB;

final readonly class CreateLessonHandler implements CreateLessonHandlerInterface
{
    public function __construct(
        private TopicRepositoryInterface $topicRepository,
        private LessonRepositoryInterface $lessonRepository,
        private LessonMapper $lessonMapper,
    ) {
    }

    public function handle(LessonCreateRequestDto $dto): LessonDto
    {
        return DB::transaction(function () use ($dto) {
            $topic = $this->topicRepository->save(
                $dto->convertToArrayForTopic()
            );

            $lesson = $this->lessonRepository->save(
                $dto->convertToArray($topic->id)
            );

            return $this->lessonMapper->fromModel($lesson);
        });
    }
}
