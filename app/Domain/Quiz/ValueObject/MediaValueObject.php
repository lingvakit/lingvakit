<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject;

use App\Domain\Media\Enum\FileType;

interface MediaValueObject
{
    public function getMediaId(): int;
    public function getFileType(): FileType;
    public function toArray(): array;
}
