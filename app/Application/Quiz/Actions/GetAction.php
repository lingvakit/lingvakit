<?php

declare(strict_types=1);

namespace App\Application\Quiz\Actions;

use App\Application\Quiz\Dto\QuizDto;
use App\Infrastructure\MS\Quiz\QuizGateway;

readonly class GetAction
{
    public function __construct(
        private QuizGateway $quizGateway,
    ) {
    }

    public function execute(string $uuid): QuizDto
    {
        $response = $this->quizGateway->getQuizDataFromMs($uuid);

        return QuizDto::fromArray($response);
    }
}