<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\QuestionsGroup;

use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Integration\Quiz\Dto\QuestionsGroupCreateRequestDto;
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
        ];
    }

    public function dto(): QuestionsGroupCreateRequestDto
    {
        return new QuestionsGroupCreateRequestDto(
            quizUuid: Uuid::fromString($this->fieldString('quizUuid')),
            uuid: Uuid::fromString($this->fieldString('uuid')),
            title: $this->fieldString('title'),
            description: $this->fieldString('description'),
            orderIndex: $this->fieldInt('orderIndex'),
            questionType: $this->fieldEnum('questionType', QuestionTypeEnum::class),
            meta: null,
            mediaFiles: null,
            questions: [

            ],
        );
    }
}
