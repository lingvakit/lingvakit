<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Kafka\Producer\BaseProducer;
use App\Notifications\VerifiedEmail;
use Illuminate\Auth\Events\Verified;

class SendVerifiedEmailKafka
{
    public function handle(Verified $event): void
    {
        $producer = app(BaseProducer::class);

        $event->user->notify(new VerifiedEmail($producer));
    }
}
