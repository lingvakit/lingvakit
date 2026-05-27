<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers;

use App\Application\Quiz\Dto\Response\QuizDto;
use App\Integration\Quiz\Dto\Request\Quiz\QuizCreateRequestDto;

interface CreateQuizHandlerInterface
{
    public function handle(QuizCreateRequestDto $dto): QuizDto;
}
