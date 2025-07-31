<?php

declare(strict_types=1);

namespace App\Kafka\Payload;

interface PayloadInterface
{
    public function toPayloadJson(): string;
}