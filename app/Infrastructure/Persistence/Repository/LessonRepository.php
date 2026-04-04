<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Application\Course\Dto\Lesson\LessonUpdateDto;
use App\Models\LMS\Lesson;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * TODO: Remove deprecated repository
 */
class LessonRepository
{
    public function getById(int $lessonId): Lesson
    {
        try {
            return Lesson::find($lessonId);
        } catch (\Throwable $e) {
            throw new Exception('Some error occurred when getting lesson');
        }
    }

    public function update(int $lessonId, LessonUpdateDto $dto): void
    {
        try {
            DB::transaction(function () use ($lessonId, $dto) {
                $lesson = Lesson::find($lessonId);

                $lesson->update([
                    'title' => $dto->title,
                    'description' => $dto->description,
                    'image' => $dto->imageMediaId,
                    'audio' => $dto->audioMediaId,
                    'video' => $dto->videoMediaId,
                    'duration' => $dto->duration,
                ]);

                $lesson->topic()->update([
                    'index_number' => $dto->orderIndex ?: null,
                    'passed_topics' => null,
                ]);
            });
        } catch (\Throwable $e) {
            throw new Exception('Some error occurred when updating lesson');
        }
    }

    public function delete(int $lessonId): void
    {
        try {
            DB::transaction(function () use ($lessonId) {
                $lesson = Lesson::find($lessonId);
                $topic = $lesson->topic()->first();

                $lesson->delete();
                $topic->delete();
            });
        } catch (\Throwable $e) {
            throw new Exception('Some error occurred when deleting lesson');
        }
    }
}
