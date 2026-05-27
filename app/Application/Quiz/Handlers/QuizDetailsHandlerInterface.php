<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers;

use App\Application\Quiz\Dto\Response\QuizDto;

interface QuizDetailsHandlerInterface
{
    public function handle(string $quizUuid): QuizDto;
}
