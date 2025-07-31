<?php

declare(strict_types=1);

namespace App\Kafka\Producer;

use App\Kafka\Exception\ProducerSendException;
use App\Kafka\Exception\TopicNotFoundException;
use App\Kafka\Payload\PayloadInterface;
use Throwable;

class Producer extends BaseProducer implements PayloadProducerInterface
{
    /**
     * @throws ProducerSendException
     * @throws Throwable
     * @throws TopicNotFoundException
     */
    public function sendMessage(PayloadInterface $payload, array $topics = []): void
    {
        $this->logger->info("Sending message as payload", ['payload' => $payload, 'topics' => $topics]);

        $payloadJson = $payload->toPayloadJson();
        foreach (array_keys($this->topics) as $topicName) {
            if ($topics && !in_array($topicName, $topics)) {
                continue;
            }
            $this->send($topicName, $payloadJson);
        }
        $this->logger->info("Message sent to topics");
    }
}