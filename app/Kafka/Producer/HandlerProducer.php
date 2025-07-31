<?php

declare(strict_types=1);

namespace App\Kafka\Producer;

use App\Kafka\Exception\ProducerConfException;
use App\Kafka\Exception\ProducerSendException;
use App\Kafka\Exception\TopicNotFoundException;
use App\Kafka\TopicConfig;
use RdKafka\Producer;
use RdKafka\ProducerTopic;
use Throwable;

class HandlerProducer implements ProducerInterface
{
    protected Producer $producer;

    /** @var ProducerTopic[] */
    protected array $topics = [];

    /**
     * @throws ProducerConfException
     */
    public function __construct(Producer $producer, array $topicsConfig)
    {
        $this->producer = $producer;

        if (!$topicsConfig) {
            throw new ProducerConfException();
        }

        foreach ($topicsConfig as $name => $config) {
            $this->topics[$name] = $this->producer->newTopic($name, $config ? new TopicConfig($config) : null);
        }
    }

    public function __destruct()
    {
        $this->producer->flush(10000);
    }

    /**
     * @throws TopicNotFoundException
     * @throws ProducerSendException
     */
    public function send(string $topic, string $message, string $key = null): void
    {
        if (!isset($this->topics[$topic])) {
            throw new TopicNotFoundException("Topic is not found: $topic");
        }

        try {
            $this->topics[$topic]->produce(RD_KAFKA_PARTITION_UA, 0, $message, $key);
        } catch (Throwable $e) {
            throw new ProducerSendException("Kafka send message error", $e->getCode(), $e);
        }
    }
}