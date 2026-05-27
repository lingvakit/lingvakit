<?php
declare(strict_types=1);

namespace App\Application\Quiz\Mapper;

use App\Application\Quiz\Dto\QuestionsGroup\Response\QuestionsGroupDto;
use App\Integration\Quiz\Dto\Response\QuestionsGroupDto as MsGroupResponseDto;
use Symfony\Component\Uid\Uuid;

class QuestionsGroupMapper
{
    public function fromMsResponse(
        MsGroupResponseDto $responseDto
    ): QuestionsGroupDto {
        return new QuestionsGroupDto(
            uuid: Uuid::fromString($responseDto->uuid),
            title: $responseDto->title,
            description: $responseDto->description,
            orderIndex: $responseDto->orderIndex,
            questionType: $responseDto->questionType,
        );
    }
}
