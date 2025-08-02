<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Kafka\Producer\BaseProducer;
use App\Notifications\VerifyEmail;
use Illuminate\Auth\Events\Registered;

class SendVerifyEmailKafka
{
    public function handle(Registered $event)
    {
        $producer = app(BaseProducer::class);

        $event->user->notify(new VerifyEmail($producer));
    }
}
