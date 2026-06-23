<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject;

interface MetaValueObject
{
    public function toArray(): array;
}
