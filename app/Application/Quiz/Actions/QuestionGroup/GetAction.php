<?php

declare(strict_types=1);

namespace App\Application\Quiz\Actions\QuestionGroup;

use App\Application\Quiz\Dto\QuestionGroupDto;
use App\Infrastructure\MS\Quiz\QuestionGroupGateway;

readonly class GetAction
{
    public function __construct(
        private QuestionGroupGateway $gateway,
    ) {
    }

    public function execute(string $uuid): QuestionGroupDto
    {
        $response = $this->gateway->getDataFromMs($uuid);

        return QuizDto::fromArray($response);
    }
}