<?php

namespace App\Notifications;

use App\Broadcasting\KafkaChannel;
use App\Dto\UserDto;
use App\Kafka\Producer\BaseProducer;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VerifiedEmail extends Notification
{
    use Queueable;

    const string EVENT_NAME = 'user.activation';

    public function __construct(
        private readonly BaseProducer $producer
    ) {
    }

    public function via($notifiable): array
    {
        return [KafkaChannel::class];
    }

    public function toKafka($notifiable): array
    {
        $user = User::where('email', $notifiable->getEmailForVerification())->first();
        $userDto = UserDto::fromModel($user);

        return [
            'eventName' => self::EVENT_NAME,
            'recipientEmail' => $user->email,
            'data' => [
                'user' => $userDto->toArray(),
                'baseUrl' => env('APP_URL'),
            ]
        ];
    }
}
