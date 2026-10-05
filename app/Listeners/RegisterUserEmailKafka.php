<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Notifications\WelcomeSetPasswordEmail;
use Illuminate\Auth\Events\Registered;

class RegisterUserEmailKafka
{
    public function handle(Registered $event): void
    {
        $event->user->notify(new WelcomeSetPasswordEmail());
    }
}
