<?php
declare(strict_types=1);

namespace App\Application\User\Dto;

final readonly class RegisterUserDto
{
    public function __construct(
        public string $name,
        public string $email,
    ) {}
}
