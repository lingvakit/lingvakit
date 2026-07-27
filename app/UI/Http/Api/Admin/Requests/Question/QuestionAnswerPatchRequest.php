<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Requests\Question;

use App\Application\Quiz\Dto\QuestionsGroup\Request\Question\QuestionAnswerCreateDto;
use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\UI\Http\Api\Admin\Requests\AbstractFormRequest;
use Illuminate\Validation\Rules\Enum;

class QuestionAnswerPatchRequest extends AbstractFormRequest
{

    public function rules(): array
    {
        return [
            'questionType' => ['required', new Enum(QuestionTypeEnum::class)],
            'value' => ['required'],
        ];
    }

    public function dto(): QuestionAnswerCreateDto
    {
        return new QuestionAnswerCreateDto(
            questionType: $this->fieldEnum('questionType', QuestionTypeEnum::class),
            value: $this->input('value')
        );
    }
}
