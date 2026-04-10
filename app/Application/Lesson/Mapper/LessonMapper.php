<?php
declare(strict_types=1);

namespace App\Application\Lesson\Mapper;

use App\Application\Lesson\Dto\LessonDto;
use App\Application\Media\Dto\MediaFileDto;
use App\Application\Media\Mapper\MediaFileMapper;
use App\Infrastructure\Persistence\Repository\MediaFileRepositoryInterface;
use App\Models\LMS\Lesson;

final readonly class LessonMapper
{
    public function __construct(
        private MediaFileMapper $mediaFileMapper,
        private MediaFileRepositoryInterface $mediaFileRepository,
    ) {
    }

    public function fromModel(Lesson $lesson): LessonDto
    {
        return new LessonDto(
            id: $lesson->id,
            title: $lesson->title,
            duration: (int)$lesson->duration,
            description: $lesson->description,
            imageFile: $this->getMediaFileDto($lesson->image),
            audioFile: $this->getMediaFileDto($lesson->audio),
            videoFile: $this->getMediaFileDto($lesson->video),
            orderIndex: $lesson->topic->index_number,
        );
    }

    private function getMediaFileDto(?int $mediaFileId = null): ?MediaFileDto
    {
        $resolvedMediaFileId = $this->resolveMediaId($mediaFileId);
        if ($resolvedMediaFileId === null) {
            return null;
        }

        $mediaFile = $this->mediaFileRepository->findById($mediaFileId);
        if ($mediaFile === null) {
            return null;
        }

        return $this->mediaFileMapper->fromModel($mediaFile);
    }

    private function resolveMediaId(string|int|null $value): ?int
    {
        if (is_numeric($value)) {
            return (int)$value;
        }

        return null;
    }
}
