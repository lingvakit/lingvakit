<?php

declare(strict_types=1);

namespace App\Kafka\Producer;

interface ProducerInterface
{
    public function send(string $topic, string $message, string $key = null): void;
}