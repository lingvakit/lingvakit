<?php
declare(strict_types = 1);

namespace App\Integration\Quiz\Mapper;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Integration\Quiz\Dto\QuestionsGroup\Response\QuestionsGroupDto;

class QuestionsGroupMapper
{
    public function fromResponseDataToDto(array $data): QuestionsGroupDto
    {
        return new QuestionsGroupDto(
            uuid: $data['uuid'],
            title: $data['title'],
            description: $data['description'],
            questionType: QuestionTypeEnum::from($data['questionType']),
            orderIndex: $data['orderIndex'],
            mediaFiles: $data['mediaFiles'] ?? null,
            meta: $data['meta'] ?? null,
            questions: $data['questions'],
        );
    }
}
