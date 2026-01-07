<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Quiz\Clients;

use App\Infrastructure\Auth\JwtService;
use Psr\Log\LoggerInterface;

abstract class BaseMsClient
{
    public function __construct(
        protected string $baseUrl,
        protected JwtService $jwtService,
        protected LoggerInterface $logger,
    ) {}
}