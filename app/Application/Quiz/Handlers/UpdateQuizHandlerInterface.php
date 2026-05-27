<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers;

use App\Application\Quiz\Dto\Response\QuizDto;
use App\Integration\Quiz\Dto\Request\Quiz\QuizUpdateRequestDto;

interface UpdateQuizHandlerInterface
{
    public function handle(string $quizUuid, QuizUpdateRequestDto $dto): QuizDto;
}
