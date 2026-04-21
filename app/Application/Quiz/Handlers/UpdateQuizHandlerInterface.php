<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers;

use App\Integration\Quiz\Dto\QuizDto;
use App\Integration\Quiz\Dto\QuizUpdateRequestDto;

interface UpdateQuizHandlerInterface
{
    public function handle(string $quizUuid, QuizUpdateRequestDto $dto): QuizDto;
}
