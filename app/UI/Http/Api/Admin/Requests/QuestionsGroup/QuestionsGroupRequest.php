<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\QuestionsGroup;

use App\Application\Quiz\Dto\QuestionsGroup\Request\Question\QuestionAnswerCreateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\Question\QuestionOptionCreateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionCreateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionsGroupCreateDto;
use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\UI\Http\Api\Admin\Requests\AbstractFormRequest;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\Uid\Uuid;

class QuestionsGroupRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'quizUuid' => ['required', 'uuid'],
            'uuid' => ['required', 'uuid'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'orderIndex' => ['nullable', 'integer'],
            'questionType' => ['required', new Enum(QuestionTypeEnum::class)],
            'meta' => ['nullable', 'array'],
            'mediaFiles' => ['nullable', 'array'],
            'questions' => ['required', 'array'],
            'questions.*.uuid' => ['required', 'uuid'],
            'questions.*.text' => ['required', 'string', 'max:255'],
            'questions.*.explanation' => ['nullable', 'string'],
            'questions.*.points' => ['required', 'integer'],
            'questions.*.orderIndex' => ['nullable', 'integer'],
            'questions.*.type' => ['required', new Enum(QuestionTypeEnum::class)],
            'questions.*.settings' => ['nullable', 'array'],
            'questions.*.options' => ['required', 'array'],
            'questions.*.answer' => ['required', 'array'],
        ];
    }

    public function dto(): QuestionsGroupCreateDto
    {
        $groupUuid = Uuid::fromString($this->fieldString('uuid'));

        return new QuestionsGroupCreateDto(
            quizUuid: Uuid::fromString($this->fieldString('quizUuid')),
            uuid: $groupUuid,
            title: $this->fieldString('title'),
            description: $this->fieldString('description'),
            orderIndex: $this->fieldInt('orderIndex'),
            questionType: $this->fieldEnum('questionType', QuestionTypeEnum::class),
            meta: null, // TODO: change to dynamic data
            media: null, // TODO: change to dynamic data
            questions: array_map(
                callback: fn($question) => new QuestionCreateDto(
                    groupUuid: $groupUuid,
                    uuid: Uuid::fromString($question['uuid']),
                    text: $question['text'],
                    explanation: $question['explanation'] ?? null,
                    points: $this->fieldInt((string)$question['points']),
                    orderIndex: isset($question['orderIndex'])
                        ? $this->fieldInt($question['orderIndex'])
                        : null,
                    type: $this->fieldEnum('questionType', QuestionTypeEnum::class),
                    settings: null, // TODO: change to dynamic data
                    options: array_map(
                        callback: fn($option) => new QuestionOptionCreateDto(
                            questionUuid: Uuid::fromString($question['uuid']),
                            uuid: Uuid::fromString($option['uuid']),
                            text: $this->fieldString($option['text']),
                            matchKey: isset($option['matchKey'])
                                ? Uuid::fromString($option['matchKey'])
                                : null,
                            orderIndex: isset($option['orderIndex'])
                                ? $this->fieldInt($option['orderIndex'])
                                : null,
                            settings: null,
                        ),
                        array: $question['options']
                    ),
                    answer: new QuestionAnswerCreateDto(
                        questionType: $this->fieldEnum('questionType', QuestionTypeEnum::class),
                        value: array_map(
                            callback: fn($value) => Uuid::fromString($value),
                            array: $question['answer']['value']
                        )
                    ),
                ),
                array: $this->field('questions')
            ),
        );
    }
}
