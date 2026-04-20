<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers;

use App\Integration\Quiz\Dto\QuizCreateRequestDto;
use App\Integration\Quiz\Dto\QuizDto;

interface CreateQuizHandlerInterface
{
    public function handle(QuizCreateRequestDto $dto): QuizDto;
}
