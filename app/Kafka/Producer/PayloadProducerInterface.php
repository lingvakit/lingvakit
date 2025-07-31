<?php

namespace App\Kafka\Producer;

use App\Kafka\Payload\PayloadInterface;

interface PayloadProducerInterface extends ProducerInterface
{
    public function sendMessage(PayloadInterface $payload, array $topics = []): void;
}