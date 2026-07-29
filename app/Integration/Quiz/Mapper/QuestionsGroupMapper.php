<?php
declare(strict_types = 1);

namespace App\Integration\Quiz\Mapper;

use App\Domain\Media\Enum\FileType;
use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Integration\Quiz\Dto\Response\MediaFileDto;
use App\Integration\Quiz\Dto\Response\QuestionsGroupDto;

readonly class QuestionsGroupMapper
{
    public function __construct(
        private QuestionMapper $questionMapper,
    ){
    }

    public function fromResponseDataToDto(array $data): QuestionsGroupDto
    {
        return new QuestionsGroupDto(
            uuid: $data['uuid'],
            title: $data['title'],
            description: $data['description'] ?? null,
            questionType: QuestionTypeEnum::from($data['questionType']),
            orderIndex: $data['orderIndex'] ?? null,
            media: array_map(
                fn($mediaFileData) => new MediaFileDto(
                    mediaId: $mediaFileData['mediaId'],
                    type: FileType::from($mediaFileData['type']),
                    altText: $mediaFileData['alt'] ?? null,
                ),
                $data['media'] ?? []
            ),
            meta: $data['meta'] ?? null,
            questions: array_map(
                fn($questionData) => $this->questionMapper->fromResponseDataToDto($questionData),
                $data['questions'] ?? []
            ),
        );
    }
}
