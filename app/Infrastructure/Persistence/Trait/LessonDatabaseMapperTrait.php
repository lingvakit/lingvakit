<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Trait;

use App\Domain\Lesson\Entity\LessonEntity;
use App\Domain\Quiz\ValueObject\MediaFile\AudioFileVO;
use App\Domain\Quiz\ValueObject\MediaFile\ImageFileVO;
use App\Domain\Quiz\ValueObject\MediaFile\VideoFileVO;
use DateTimeImmutable;

trait LessonDatabaseMapperTrait
{
    protected function mapToEntity(object $row): LessonEntity
    {
        $lessonEntity = new LessonEntity(
            id: (int)$row->id,
            title: $row->title,
            description: $row->description,
            media: null,
            duration: (int)$row->duration,
            topicId: (int)$row->topic_id,
            createdAt: $row->created_at
                ? new DateTimeImmutable((string) $row->created_at)
                : new DateTimeImmutable(),
            updatedAt: $row->updated_at
                ? new DateTimeImmutable((string) $row->updated_at)
                : null,
            deletedAt: $row->deleted_at
                ? new DateTimeImmutable((string) $row->deleted_at)
                : null,
        );

        if (!empty($row->image) && ctype_digit((string)$row->image)) {
            $lessonEntity->addMedia(
                new ImageFileVO((int)$row->image)
            );
        }

        if (!empty($row->audio) && ctype_digit((string)$row->audio)) {
            $lessonEntity->addMedia(
                new AudioFileVO((int)$row->audio)
            );
        }

        if (!empty($row->video) && ctype_digit((string)$row->video)) {
            $lessonEntity->addMedia(
                new VideoFileVO((int)$row->video)
            );
        }

        return $lessonEntity;
    }

    protected function mapToArray(LessonEntity $lesson): array
    {
        $data = [
            'title' => $lesson->getTitle(),
            'description' => $lesson->getDescription(),
            'duration' => $lesson->getDuration(),
            'topic_id' => $lesson->getTopicId(),
            'image' => null,
            'audio' => null,
            'video' => null,
        ];

        foreach ($lesson->getMedia() as $media) {
            if ($media instanceof AudioFileVO) {
                $data['audio'] = $media->getMediaId();
            } elseif ($media instanceof ImageFileVO) {
                $data['image'] = $media->getMediaId();
            } elseif ($media instanceof VideoFileVO) {
                $data['video'] = $media->getMediaId();
            }
        }

        return $data;
    }
}
