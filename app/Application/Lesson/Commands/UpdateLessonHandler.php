<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

use App\Application\Lesson\Dto\LessonDto;
use App\Application\Lesson\Dto\LessonUpdateRequestDto;
use App\Application\Lesson\Mapper\LessonMapper;
use App\Exceptions\LessonNotExistsException;
use App\Infrastructure\Persistence\Repository\LessonRepositoryInterface;
use App\Infrastructure\Persistence\Repository\TopicRepositoryInterface;
use Illuminate\Support\Facades\DB;

final readonly class UpdateLessonHandler implements UpdateLessonHandlerInterface
{
    public function __construct(
        private TopicRepositoryInterface $topicRepository,
        private LessonRepositoryInterface $lessonRepository,
        private LessonMapper $lessonMapper,
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

            $this->topicRepository->update(
                topic: $lesson->topic,
                data: $dto->convertToArray(),
            );

            $this->lessonRepository->update(
                lesson: $lesson,
                data: $dto->convertToArray(),
            );

            return $this->lessonMapper->fromModel($lesson);
        });
    }
}
