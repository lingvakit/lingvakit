<?php
declare(strict_types=1);

namespace App\Notifications;

use App\Broadcasting\KafkaChannel;
use App\Dto\UserDto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;

final class WelcomeSetPasswordEmail extends Notification implements ShouldQueue
{
    use Queueable;

    const string EVENT_NAME = 'user.registration';

    public int $tries = 5;

    public function backoff(): array
    {
        return [10, 60, 300, 900];
    }

    public function via($notifiable): array
    {
        return [KafkaChannel::class];
    }

    public function toKafka($notifiable): array
    {
        $token = Password::broker()->createToken($notifiable);

        return [
            'eventName' => self::EVENT_NAME,
            'recipientEmail' => $notifiable->email,
            'data' => [
                'user' => UserDto::fromModel($notifiable)->toArray(),
                'setPasswordUrl' => route('password.reset', [
                    'token' => $token,
                    'email' => $notifiable->email,
                    'welcome' => 1,
                ]),
                'expiresInMinutes' => (int) config('auth.passwords.users.expire'),
                'baseUrl' => config('app.url'),
            ]
        ];
    }
}
