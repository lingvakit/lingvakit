<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject;

interface SettingsValueObject
{
    public function toArray(): array;
}
