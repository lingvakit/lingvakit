<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Auth\Requests;

use App\Application\User\Dto\RegisterUserDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email:rfc',
                'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'agreement' => ['accepted'],
        ];
    }

    public function isBot(): bool
    {
        return $this->filled('hp_company');
    }

    public function toDto(): RegisterUserDto
    {
        /** @var array{
         *     name: string,
         *     email: string
         * } $data
         */
        $data = $this->validated();

        return new RegisterUserDto(
            name: $data['name'],
            email: $data['email']
        );
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Этот email уже зарегистрирован. Забыли пароль? Воспользуйтесь восстановлением.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => mb_strtolower(trim((string)$this->input('email'))),
            'name' => trim((string)$this->input('name')),
        ]);
    }
}
