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

            // Questions validation
            'questions' => ['required', 'array'],
            'questions.*.uuid' => ['required', 'uuid'],
            'questions.*.text' => ['required', 'string', 'max:255'],
            'questions.*.explanation' => ['nullable', 'string'],
            'questions.*.points' => ['required', 'integer'],
            'questions.*.orderIndex' => ['nullable', 'integer'],
            'questions.*.type' => ['required', new Enum(QuestionTypeEnum::class)],
            'questions.*.settings' => ['nullable', 'array'],

            // Strict validation of options
            'questions.*.options' => ['required', 'array'],
            'questions.*.options.*.uuid' => ['required', 'uuid'],
            'questions.*.options.*.text' => ['required', 'string', 'max:255'],
            'questions.*.options.*.matchKey' => ['nullable', 'uuid'],
            'questions.*.options.*.orderIndex' => ['nullable', 'integer'],

            // Answer validation
            'questions.*.answer' => ['required', 'array'],
            'questions.*.answer.questionType' => ['required', new Enum(QuestionTypeEnum::class)],
            'questions.*.answer.value' => ['required', 'array'],
            'questions.*.answer.value.*' => ['required', 'uuid'],
        ];
    }

    public function dto(): QuestionsGroupCreateDto
    {
        $groupUuid = Uuid::fromString($this->fieldString('uuid'));
        $questions = $this->field('questions');

        return new QuestionsGroupCreateDto(
            quizUuid: Uuid::fromString($this->fieldString('quizUuid')),
            uuid: $groupUuid,
            title: $this->fieldString('title'),
            description: $this->fieldString('description'),
            orderIndex: $this->fieldInt('orderIndex'),
            questionType: $this->fieldEnum('questionType', QuestionTypeEnum::class),
            meta: null,
            media: null,
            questions: array_map(
                callback: fn(array $question) => new QuestionCreateDto(
                    groupUuid: $groupUuid,
                    uuid: Uuid::fromString($question['uuid']),
                    text: $question['text'],
                    explanation: $question['explanation'] ?? null,
                    points: (int) $question['points'],
                    orderIndex: isset($question['orderIndex']) ? (int) $question['orderIndex'] : null,
                    type: QuestionTypeEnum::from($question['type']),
                    settings: null,
                    options: array_map(
                        callback: fn(array $option) => new QuestionOptionCreateDto(
                            questionUuid: Uuid::fromString($question['uuid']),
                            uuid: Uuid::fromString($option['uuid']),
                            text: (string) $option['text'],
                            matchKey: isset($option['matchKey']) ? Uuid::fromString($option['matchKey']) : null,
                            orderIndex: isset($option['orderIndex']) ? (int) $option['orderIndex'] : null,
                            settings: null,
                        ),
                        array: $question['options'] ?? []
                    ),
                    answer: new QuestionAnswerCreateDto(
                        questionType: QuestionTypeEnum::from($question['answer']['questionType']),
                        value: array_map(
                            callback: fn(string $value) => Uuid::fromString($value),
                            array: $question['answer']['value'] ?? []
                        )
                    ),
                ),
                array: $questions
            ),
        );
    }
}
