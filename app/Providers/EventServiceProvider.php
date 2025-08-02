<?php

namespace App\Providers;

use App\Listeners\SendVerifiedEmailKafka;
use App\Listeners\SendVerifyEmailKafka;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [SendVerifyEmailKafka::class],
        Verified::class => [SendVerifiedEmailKafka::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
