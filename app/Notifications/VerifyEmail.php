<?php

namespace App\Notifications;

use App\Broadcasting\KafkaChannel;
use App\Dto\UserDto;
use App\Kafka\Producer\BaseProducer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Notification
{
    use Queueable;

    const string EVENT_NAME = 'user.registration';

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
        $userDto = UserDto::fromModel($user, $this->verificationUrl($notifiable));

        return [
            'eventName' => self::EVENT_NAME,
            'recipientEmail' => $user->email,
            'data' => [
                'user' => $userDto->toArray(),
                'baseUrl' => env('APP_URL'),
            ]
        ];
    }

    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
