<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\User;

readonly class UserDto
{
    public function __construct(
        private int $id,
        private string $email,
        private ?string $name = null,
        private ?string $surname = null,
        private ?string $verificationLink = null,
    ) {
    }

    public static function fromModel(User $user, $verificationLink = null): self
    {
        return new self(
            id: $user->id,
            email: $user->email,
            name: $user->name,
            surname: $user->surname,
            verificationLink: $verificationLink
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'surname' => $this->surname,
            'verificationLink' => $this->verificationLink,
        ];
    }
}