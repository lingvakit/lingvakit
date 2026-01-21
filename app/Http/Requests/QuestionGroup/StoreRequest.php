<?php

declare(strict_types=1);

namespace App\Http\Requests\QuestionGroup;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Uid\Uuid;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question_group_title' => ['required', 'string'],
            'question_text' => ['required', 'string'],
            'question_points' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function toMsPayload(string $uuid, string $questionType): array
    {
        $correctIndex = (int) $this->input('question_option_is_correct', 0);
        $options = $this->getOptions($questionType);

        return [
            'quizUuid' => $uuid,
            'title' => $this->input('question_group_title'),
            'imageId' => $this->input('question_group_image'),
            'type' => $questionType,
            'description' => $this->input('question_group_description'),
            'fontSize' => $this->input('font_size'),
            'questions' => [
                [
                    'uuid' => Uuid::v4()->toRfc4122(),
                    'text' => $this->input('question_text'),
                    'type' => $questionType,
                    'explanation' => null,
                    'points' => (int) $this->input('question_points'),
                    'orderIndex' => null,
                    'settings' => null,
                    'answer' => [
                        'type' => $questionType,
                        'value' => $options[$correctIndex]['uuid'] ?? null,
                    ],
                    'options' => $options
                ]
            ]
        ];
    }

    private function getOptions(string $questionType): array
    {
        $optionValues = $this->input('question_option_values', []);

        return array_map(
            fn($value) => [
                'type' => $questionType,
                'uuid' => Uuid::v4()->toRfc4122(),
                'value' => $value,
            ],
            $optionValues
        );
    }
}