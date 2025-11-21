<?php

declare(strict_types=1);

namespace App\Domain\Quiz\Repositories;

use App\Models\LMS\Quiz;

interface QuizRepository
{
    public function store(array $data): Quiz;
    public function update(Quiz $quiz, array $data): Quiz;
    public function delete(Quiz $quiz): void;
}
