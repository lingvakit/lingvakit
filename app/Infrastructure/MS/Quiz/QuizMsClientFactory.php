<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Quiz;

use App\Infrastructure\Auth\JwtService;
use App\Infrastructure\MS\Quiz\Clients\BaseMsClient;
use Psr\Log\LoggerInterface;

final readonly class QuizMsClientFactory
{
    public function __construct(
        private JwtService $jwtService,
        private LoggerInterface $logger
    ) {
    }

    public function make(string $clientClass): BaseMsClient
    {
        return new $clientClass(
            baseUrl: config('app.url') . config('services.ms.quiz'),
            jwtService: $this->jwtService,
            logger: $this->logger,
        );
    }
}
