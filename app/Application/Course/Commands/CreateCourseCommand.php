<?php
declare(strict_types=1);

namespace App\Application\Course\Commands;

use App\Application\Course\Enum\DifficultyLevelEnum;

final readonly class CreateCourseCommand
{
    public function __construct(
        public string $title,
        public ?string $description,
        public DifficultyLevelEnum $difficultyLevel,
        public string $price,
        public int $duration,
        public ?int $imageId,
    ) {}
}
