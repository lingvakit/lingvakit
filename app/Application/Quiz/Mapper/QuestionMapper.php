<?php
declare(strict_types=1);

namespace App\Application\Quiz\Mapper;

use App\Application\Quiz\Dto\Question\QuestionDto;
use App\Application\Quiz\Dto\QuestionAnswer\QuestionAnswerDto;
use App\Application\Quiz\Dto\QuestionOption\QuestionOptionDto;
use App\Integration\Quiz\Dto\Response\QuestionDto as MsQuestionResponseDto;

class QuestionMapper
{
    public function fromMsResponse(
        MsQuestionResponseDto $responseDto
    ): QuestionDto {
        return new QuestionDto(
            uuid: $responseDto->uuid,
            text: $responseDto->text,
            type: $responseDto->type,
            explanation: $responseDto->explanation,
            points: $responseDto->points,
            orderIndex: $responseDto->orderIndex,
            media: null,
            settings: $responseDto->settings,
            answer: new QuestionAnswerDto(
                questionType: $responseDto->answer->questionType,
                value: $responseDto->answer->value,
            ),
            options: array_map(
                fn($option) => new QuestionOptionDto(
                    uuid: $option->uuid,
                    text: $option->text,
                    matchKey: $option->matchKey,
                    orderIndex: $option->orderIndex,
                    media: null,
                    settings: $option->settings,
                ),
                $responseDto->options
            ),
        );
    }
}
