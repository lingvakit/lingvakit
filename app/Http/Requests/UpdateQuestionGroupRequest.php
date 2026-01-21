<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Uid\Uuid;

class UpdateQuestionGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question_group_title' => ['required', 'string'],
        ];
    }

    public function toMsPayload(): array
    {
        return [
            'title' => $this->input('question_group_title'),
        ];
    }
}