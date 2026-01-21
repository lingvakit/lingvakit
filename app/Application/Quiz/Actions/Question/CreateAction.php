<?php

declare(strict_types=1);

namespace App\Application\Quiz\Actions\Question;

use App\Infrastructure\MS\Quiz\QuestionGateway;

readonly class CreateAction
{
    public function __construct(
        private QuestionGateway $questionGateway,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function execute(array $data): string
    {
        try {
            // Create question in microservice
            $uuid = $this->questionGateway->storeInMs($data);
        } catch (\Throwable $exception) {
            throw new \Exception('Quiz uuid is not valid');
        }

        return $uuid;
    }
}