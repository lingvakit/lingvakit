<?php

declare(strict_types=1);

namespace App\Domain\Quiz\Repositories;

use App\Models\LMS\Question;

interface QuestionRepository
{
    public function store(array $data): Question;
}
