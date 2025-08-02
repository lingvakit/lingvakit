<?php

declare(strict_types=1);

namespace App\Broadcasting;

use App\Kafka\Exception\ProducerSendException;
use App\Kafka\Exception\TopicNotFoundException;
use App\Kafka\Producer\BaseProducer;
use Illuminate\Notifications\Notification;

class KafkaChannel
{
    const string TOPIC = 'notification.user';

    public function __construct(
        protected BaseProducer $producer
    ) {}

    /**
     * @throws ProducerSendException
     * @throws \Throwable
     * @throws TopicNotFoundException
     */
    public function send($notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toKafka')) {
            return;
        }

        $message = $notification->toKafka($notifiable);

        $this->producer->send(self::TOPIC, json_encode($message));
    }
}
