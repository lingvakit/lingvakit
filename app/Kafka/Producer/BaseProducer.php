<?php

declare(strict_types=1);

namespace App\Kafka\Producer;

use App\Kafka\Exception\ProducerSendException;
use App\Kafka\Exception\TopicNotFoundException;
use Psr\Log\LoggerInterface;
use RdKafka\Producer;
use Throwable;

class BaseProducer extends HandlerProducer
{
    protected LoggerInterface $logger;

    public function __construct(
        Producer $producer,
        array $topicsConfig,
        LoggerInterface $logger
    ) {
        parent::__construct($producer, $topicsConfig);
        $this->logger = $logger;
    }

    /**
     * @throws ProducerSendException
     * @throws Throwable
     * @throws TopicNotFoundException
     */
    public function send(string $topic, string $message, string $key = null): void
    {
        $this->logger->info("Sending string message", [
            'topic' => $topic,
            'message' => $message,
            'key' => $key
        ]);

        try {
            parent::send($topic, $message, $key);
            $this->logger->info("Sending successfully sent");
        } catch (Throwable $e) {
            $this->logger->error("Error while sending message to kafka", [
                'topic' => $topic,
                'message' => $message,
                'exception' => (string)$e
            ]);
            throw $e;
        }
    }
}