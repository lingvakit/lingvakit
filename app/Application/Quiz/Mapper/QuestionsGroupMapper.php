<?php
declare(strict_types=1);

namespace App\Application\Quiz\Mapper;

use App\Application\Quiz\Dto\Question\QuestionDto;
use App\Application\Quiz\Dto\QuestionAnswer\QuestionAnswerDto;
use App\Application\Quiz\Dto\QuestionOption\QuestionOptionDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\Question\QuestionAnswerCreateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\Question\QuestionOptionCreateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionCreateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionsGroupCreateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Response\QuestionsGroupDto;
use App\Domain\Quiz\Entity\QuestionGroupEntity;
use App\Integration\Quiz\Dto\Response\QuestionsGroupDto as MsGroupResponseDto;
use Symfony\Component\Uid\Uuid;

class QuestionsGroupMapper
{
    public function toMsPayload(
        QuestionGroupEntity $questionGroup,
        Uuid $quizUuid
    ): QuestionsGroupCreateDto {
        return new QuestionsGroupCreateDto(
            quizUuid: $quizUuid,
            uuid: $questionGroup->getUuid(),
            title: $questionGroup->getTitle(),
            description: $questionGroup->getDescription(),
            orderIndex: $questionGroup->getOrderIndex(),
            questionType: $questionGroup->getQuestionType(),
            meta: $questionGroup->getMeta()->toArray(),
            media: array_map(
                fn($media) => $media->toArray(),
                $questionGroup->getMedia()
            ),
            questions: array_map(fn($question) => new QuestionCreateDto(
                groupUuid: $questionGroup->getUuid(),
                uuid: $question->getUuid(),
                text: $question->getText(),
                explanation: $question->getExplanation(),
                points: $question->getPoints(),
                orderIndex: $question->getOrderIndex(),
                type: $question->getType(),
                settings: $question->getSettings(),
                options: array_map(fn($option) => new QuestionOptionCreateDto(
                    questionUuid: $question->getUuid(),
                    uuid: $option->getUuid(),
                    text: $option->getText(),
                    matchKey: $option->getMatchKey(),
                    orderIndex: $option->getOrderIndex(),
                    media: $option->getMedia(),
                    settings: $option->getSettings()?->toArray(),
                ), $question->getOptions()),
                answer: new QuestionAnswerCreateDto(
                    questionType: $question->getType(),
                    value: $question->getAnswer()->getValue(),
                ),
            ), $questionGroup->getQuestions()),
        );
    }

    public function fromMsResponse(
        MsGroupResponseDto $responseDto
    ): QuestionsGroupDto {
        return new QuestionsGroupDto(
            uuid: Uuid::fromString($responseDto->uuid),
            title: $responseDto->title,
            description: $responseDto->description,
            orderIndex: $responseDto->orderIndex,
            questionType: $responseDto->questionType,
            media: $responseDto->media,
            meta: $responseDto->meta,
            questions: array_map(fn($question) => new QuestionDto(
                uuid: $question->uuid,
                text: $question->text,
                type: $question->type,
                explanation: $question->explanation,
                points: $question->points,
                orderIndex: $question->orderIndex,
                media: null,
                settings: $question->settings,
                answer: new QuestionAnswerDto(
                    questionType: $question->answer->questionType,
                    value: $question->answer->value,
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
                    $question->options
                ),
            ),
                $responseDto->questions
            ),
        );
    }
}
