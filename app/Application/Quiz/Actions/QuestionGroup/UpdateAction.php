<?php

declare(strict_types=1);

namespace App\Application\Quiz\Actions\QuestionGroup;

use App\Infrastructure\MS\Quiz\QuestionGroupGateway;

class UpdateAction
{
    public function __construct(
        private QuestionGroupGateway $gateway
    ) {}

    public function execute(string $uuid, array $data = []): void
    {
        $this->gateway->updateInMs($uuid, $data);
    }
}