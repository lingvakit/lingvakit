<?php
declare(strict_types=1);

namespace App\Providers;

use App\Integration\Media\Client\MediaClient;
use App\Integration\Media\Client\MediaClientInterface;
use Illuminate\Support\ServiceProvider;

class IntegrationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            abstract: MediaClientInterface::class,
            concrete: MediaClient::class
        );
    }
}
