<?php
declare(strict_types=1);

namespace App\Providers;

use App\Application\Module\Commands\CreateModuleHandler;
use App\Application\Module\Commands\CreateModuleHandlerInterface;
use App\Application\Module\Commands\ShowModuleHandler;
use App\Application\Module\Commands\ShowModuleHandlerInterface;
use App\Application\Module\Commands\UpdateModuleHandler;
use App\Application\Module\Commands\UpdateModuleHandlerInterface;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            abstract: ShowModuleHandlerInterface::class,
            concrete: ShowModuleHandler::class
        );

        $this->app->bind(
            abstract: CreateModuleHandlerInterface::class,
            concrete: CreateModuleHandler::class
        );

        $this->app->bind(
            abstract: UpdateModuleHandlerInterface::class,
            concrete: UpdateModuleHandler::class
        );
    }
}
