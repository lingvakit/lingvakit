<?php

declare(strict_types=1);

namespace App\Application\Quiz\Actions\QuestionGroup;

use App\Infrastructure\MS\Quiz\QuestionGroupGateway;

readonly class StoreAction
{
    public function __construct(
        private QuestionGroupGateway $questionGroupGateway,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function execute(array $data): string
    {
        $sa = 0;

        try {
            // Create question group in microservice
            $questionGroupUuid = $this->questionGroupGateway->storeInMs($data);
        } catch (\Throwable $exception) {
            throw new \Exception('Quiz uuid is not valid');
        }

        return $questionGroupUuid;
    }
}