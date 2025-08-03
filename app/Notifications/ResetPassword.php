<?php

namespace App\Notifications;

use App\Broadcasting\KafkaChannel;
use App\Dto\UserDto;
use App\Exceptions\ResetPasswordUserNotExistsException;
use App\Kafka\Producer\BaseProducer;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;

    const string EVENT_NAME = 'user.reset_password';

    public function __construct(
        private readonly BaseProducer $producer,
        private readonly string $token,
    ) {
    }

    public function via($notifiable): array
    {
        return [KafkaChannel::class];
    }

    /**
     * @throws ResetPasswordUserNotExistsException
     */
    public function toKafka($notifiable): array
    {
        $email = $notifiable->getEmailForPasswordReset();

        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $email
        ], false));

        $user = User::where('email', $email)->first();
        if (!$user) {
            throw new ResetPasswordUserNotExistsException("User with email '{$email}' not found");
        }

        $userDto = UserDto::fromModel(user: $user, resetPasswordLink: $resetUrl);

        return [
            'eventName' => self::EVENT_NAME,
            'recipientEmail' => $email,
            'data' => [
                'user' => $userDto->toArray(),
                'baseUrl' => env('APP_URL'),
            ]
        ];
    }
}
