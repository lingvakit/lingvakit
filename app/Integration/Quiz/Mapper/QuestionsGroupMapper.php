<?php
declare(strict_types = 1);

namespace App\Integration\Quiz\Mapper;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Integration\Quiz\Dto\Response\MediaFileDto;
use App\Integration\Quiz\Dto\Response\QuestionAnswerDto;
use App\Integration\Quiz\Dto\Response\QuestionDto;
use App\Integration\Quiz\Dto\Response\QuestionOptionDto;
use App\Integration\Quiz\Dto\Response\QuestionsGroupDto;

class QuestionsGroupMapper
{
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
                    type: $mediaFileData['type'],
                    altText: $mediaFileData['alt'],
                ),
                $data['media'] ?? []
            ),
            meta: $data['meta'] ?? null,
            questions: array_map(
                fn($questionData) => new QuestionDto(
                    uuid: $questionData['uuid'],
                    text: $questionData['text'],
                    type: QuestionTypeEnum::from($questionData['type']),
                    explanation: $questionData['explanation'] ?? null,
                    points: $questionData['points'] ?? null,
                    orderIndex: $questionData['orderIndex'] ?? null,
                    settings: $questionData['settings'] ?? null,
                    answer: new QuestionAnswerDto(
                        $questionData['answer']['value'],
                        QuestionTypeEnum::from($questionData['answer']['questionType']),
                    ),
                    options: array_map(
                        fn($optionData) => new QuestionOptionDto(
                            uuid: $optionData['uuid'],
                            text: $optionData['text'] ?? null,
                            matchKey: $optionData['matchKey'] ?? null,
                            orderIndex: $optionData['orderIndex'] ?? null,
                            settings: $optionData['settings'] ?? null,
                        ),
                        $questionData['options'] ?? []
                    ),
                ),
                $data['questions'] ?? []
            ),
        );
    }
}
