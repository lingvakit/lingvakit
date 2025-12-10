<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Quiz\Repositories\QuizRepository;
use App\Models\LMS\Quiz;

class QuizRepositoryEloquent implements QuizRepository
{
    public function findById(int $id): ?Quiz
    {
        return Quiz::find($id);
    }

    public function store(array $data): Quiz
    {
        return Quiz::create($data);
    }

    public function update(Quiz $quiz, array $data): Quiz
    {
        $quiz->update($data);

        return $quiz;
    }

    public function delete(Quiz $quiz): void
    {
        $quiz->delete();
    }
}
