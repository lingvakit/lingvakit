<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

use App\Application\Lesson\Dto\LessonDto;
use App\Application\Lesson\Mapper\LessonMapper;
use App\Exceptions\LessonNotExistsException;
use App\Infrastructure\Persistence\Repository\LessonRepositoryInterface;
use Illuminate\Support\Facades\DB;

final readonly class ShowLessonHandler implements ShowLessonHandlerInterface
{
    public function __construct(
        private LessonRepositoryInterface $repository,
        private LessonMapper $lessonMapper
    ) {}

    public function handle(int $lessonId): LessonDto
    {
        return DB::transaction(function () use ($lessonId) {
            $lesson = $this->repository->findById($lessonId);

            if ($lesson === null) {
                throw new LessonNotExistsException(
                    message: "Lesson with id {$lessonId} not found"
                );
            }

            return $this->lessonMapper->fromModel($lesson);
        });
    }
}
