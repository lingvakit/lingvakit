<?php

namespace App\Providers;

use App\Kafka\Producer\BaseProducer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use RdKafka\Conf;
use RdKafka\Producer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Kafka producer
        $this->app->singleton(BaseProducer::class, function ($app) {
            $topicsConfig = config('kafka.topics');

            $conf = new Conf();
            $conf->set('metadata.broker.list', env('KAFKA'));

            $producer = new Producer($conf);

            $logger = $app->make(LoggerInterface::class);

            return new BaseProducer($producer, $topicsConfig, $logger);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'layouts.cms.sidebar',
            'layouts.site.header',
            'cms.students.show',
        ], function ($view) {
            $currentUser = Auth::user();
            if ($currentUser) {
                $view->with(['currentUser' => $currentUser]);
            }
        });

        // Chat's Sidebar
        view()->composer('layouts.chat.sidebar', function ($view) {
            $currentUser = auth()->user();
            if ($currentUser->hasRole(['teacher', 'admin'])) {
                $contacts = $currentUser->getMyStudents();
            } else {
                $contacts = $currentUser->getMyTeachers();
            }

            $params = [
                'currentUser' => $currentUser,
                'contacts' => $contacts
            ];

            if ($currentUser->hasRole(["admin", "teacher"])) {
                $params['contacts'] = $currentUser->getMyStudents();
            }

            $view->with($params);
        });
    }
}
