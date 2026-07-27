<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Mapper;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Integration\Quiz\Dto\Response\QuestionDto;
use App\Integration\Quiz\Dto\Response\QuestionOptionDto;

class QuestionMapper
{
    public function fromResponseDataToDto(array $data): QuestionDto
    {
        return new QuestionDto(
            uuid: $data['uuid'],
            text: $data['text'],
            type: QuestionTypeEnum::from($data['type']),
            explanation: $data['explanation'] ?? null,
            points: $data['points'] ?? null,
            orderIndex: $data['orderIndex'] ?? null,
            settings: $data['settings'] ?? null,
            answer: QuestionTypeEnum::getAnswerDto($data['answer']),
            options: array_map(
                fn($optionData) => new QuestionOptionDto(
                    uuid: $optionData['uuid'],
                    text: $optionData['text'] ?? null,
                    matchKey: $optionData['matchKey'] ?? null,
                    orderIndex: $optionData['orderIndex'] ?? null,
                    settings: $optionData['settings'] ?? null,
                ),
                $data['options'] ?? []
            ),
        );
    }
}
