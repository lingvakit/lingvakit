<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Trait;

use App\Domain\Quiz\Entity\QuizEntity;
use App\Domain\Quiz\ValueObject\MediaFile\AudioFileVO;
use App\Domain\Quiz\ValueObject\MediaFile\ImageFileVO;
use App\Domain\Quiz\ValueObject\MediaFile\VideoFileVO;
use DateTimeImmutable;

trait QuizDatabaseMapperTrait
{
    protected function mapToEntity(object $row): QuizEntity
    {
        $quizEntity = new QuizEntity(
            id: $row->id,
            title: $row->title,
            description: $row->description,
            media: null,
            timeLimit: (int)$row->duration,
            passingScore: (int)$row->passing_score,
            topicId: $row->topic_id,
            categoryId: $row->category_id,
            moduleId: $row->module_id,
            orderIndex: $row->order_index,
            questionGroups: null,
            createdAt: $row->created_at
                ? new DateTimeImmutable($row->created_at)
                : new DateTimeImmutable(),
            updatedAt: $row->updated_at
                ? new DateTimeImmutable($row->updated_at)
                : null,
        );

        if (!empty($row->image) && ctype_digit((string)$row->image)) {
            $quizEntity->addMedia(
                new ImageFileVO((int)$row->image)
            );
        }

        if (!empty($row->audio) && ctype_digit((string)$row->audio)) {
            $quizEntity->addMedia(
                new AudioFileVO((int)$row->audio)
            );
        }

        if (!empty($row->video) && ctype_digit((string)$row->video)) {
            $quizEntity->addMedia(
                new VideoFileVO((int)$row->video)
            );
        }

        return $quizEntity;
    }
}
