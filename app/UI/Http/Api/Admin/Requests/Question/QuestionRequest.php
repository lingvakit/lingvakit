<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\Question;

use App\Application\Quiz\Dto\QuestionsGroup\Request\Question\QuestionAnswerCreateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\Question\QuestionOptionCreateDto;
use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Integration\Quiz\Dto\Request\Question\QuestionCreateDto;
use App\UI\Http\Api\Admin\Requests\AbstractFormRequest;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\Uid\Uuid;

class QuestionRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'questionGroupUuid' => ['required', 'uuid'],
            'uuid' => ['required', 'uuid'],
            'text' => ['required', 'string', 'max:255'],
            'explanation' => ['nullable', 'string'],
            'points' => ['required', 'integer'],
            'orderIndex' => ['nullable', 'integer'],
            'type' => ['required', new Enum(QuestionTypeEnum::class)],
            'settings' => ['nullable', 'array'],

            // Answer validation
            'answer' => ['required', 'array'],
            'answer.questionType' => ['required', new Enum(QuestionTypeEnum::class)],
            'answer.value' => ['required', 'array'],
            'answer.value.*' => ['required', 'uuid'],

            // Strict validation of options
            'options' => ['required', 'array'],
            'options.*.questionUuid' => ['required', 'uuid'],
            'options.*.uuid' => ['required', 'uuid'],
            'options.*.text' => ['required', 'string', 'max:255'],
            'options.*.matchKey' => ['nullable', 'uuid'],
            'options.*.orderIndex' => ['nullable', 'integer'],
        ];
    }

    public function dto(): QuestionCreateDto
    {
        $groupUuid = Uuid::fromString($this->fieldString('questionGroupUuid'));
        $uuid = Uuid::fromString($this->fieldString('uuid'));
        $options = $this->field('options');
        $questionType = QuestionTypeEnum::from($this->fieldString('type'));

        return new QuestionCreateDto(
            groupUuid: $groupUuid,
            uuid: $uuid,
            text: $this->fieldString('text'),
            explanation: $this->fieldString('explanation'),
            points: (int) $this->fieldInt('points'),
            orderIndex: $this->fieldInt('orderIndex'),
            type: $questionType,
            settings: null,
            options: array_map(
                callback: fn(array $option) => new QuestionOptionCreateDto(
                    questionUuid: $uuid,
                    uuid: Uuid::fromString($option['uuid']),
                    text: (string) $option['text'],
                    matchKey: isset($option['matchKey']) ? Uuid::fromString($option['matchKey']) : null,
                    orderIndex: isset($option['orderIndex']) ? (int) $option['orderIndex'] : null,
                    settings: null,
                ),
                array: $options ?? []
            ),
            answer: new QuestionAnswerCreateDto(
                questionType: $questionType,
                value: array_map(
                    callback: fn(string $value) => Uuid::fromString($value),
                    array: $this->field('answer')['value'] ?? []
                )
            ),
        );
    }
}
