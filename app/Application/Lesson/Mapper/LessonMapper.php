<?php
declare(strict_types=1);

namespace App\Application\Lesson\Mapper;

use App\Application\Lesson\Dto\LessonDto;
use App\Application\Media\Dto\MediaFileDto;
use App\Application\Media\Mapper\MediaFileMapper;
use App\Domain\Lesson\Entity\LessonEntity;
use App\Domain\Quiz\ValueObject\MediaFile\AudioFileVO;
use App\Domain\Quiz\ValueObject\MediaFile\ImageFileVO;
use App\Domain\Quiz\ValueObject\MediaFile\VideoFileVO;
use App\Domain\Topic\Entity\TopicEntity;
use App\Infrastructure\Persistence\Repository\MediaFileRepositoryInterface;

final readonly class LessonMapper
{
    public function __construct(
        private MediaFileMapper $mediaFileMapper,
        private MediaFileRepositoryInterface $mediaFileRepository,
    ) {
    }

    public function fromEntity(
        LessonEntity $lesson,
        TopicEntity $topic
    ): LessonDto {
        $media = [
            'audio' => null,
            'image' => null,
            'video' => null,
        ];

        foreach ($lesson->getMedia() ?? [] as $mediaFile) {
            if ($mediaFile instanceof AudioFileVO) {
                $media['audio'] = $mediaFile->getMediaId();
            } elseif ($mediaFile instanceof ImageFileVO) {
                $media['image'] = $mediaFile->getMediaId();
            } elseif ($mediaFile instanceof VideoFileVO) {
                $media['video'] = $mediaFile->getMediaId();
            }
        }

        return new LessonDto(
            id: $lesson->getId(),
            title: $lesson->getTitle(),
            duration: $lesson->getDuration(),
            description: $lesson->getDescription(),
            imageFile: $this->getMediaFileDto($media['audio']),
            audioFile: $this->getMediaFileDto($media['image']),
            videoFile: $this->getMediaFileDto($media['video']),
            orderIndex: $topic->getOrderIndex(),
        );
    }

    private function getMediaFileDto(string|int|null $mediaFileId = null): ?MediaFileDto
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
