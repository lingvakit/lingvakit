<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Quiz\Repositories\QuestionRepository;
use App\Models\LMS\Question;

class QuestionRepositoryEloquent implements QuestionRepository
{
    public function store(array $data): Question
    {
        return Question::create($data);
    }
}
