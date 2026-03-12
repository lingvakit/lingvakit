<?php
declare(strict_types=1);

namespace App\Providers;

use App\Application\Category\ReadModel\CategoryReadRepository;
use App\Application\Course\ReadModel\CourseReadRepository;
use App\Application\Media\ReadModel\MediaFileRepository;
use App\Infrastructure\Persistence\Eloquent\Category\EloquentCategoryReadRepository;
use App\Infrastructure\Persistence\Eloquent\Course\EloquentCourseReadRepository;
use App\Infrastructure\Persistence\Eloquent\MediaFile\EloquentMediaFileRepository;
use App\Kafka\Producer\BaseProducer;
use Illuminate\Auth\Notifications\VerifyEmail;
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
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return null;
        });

        // Kafka producer
        $this->app->singleton(BaseProducer::class, function ($app) {
            $topicsConfig = config('kafka.topics');

            $conf = new Conf();
            $conf->set('metadata.broker.list', env('KAFKA'));

            $producer = new Producer($conf);

            $logger = $app->make(LoggerInterface::class);

            return new BaseProducer($producer, $topicsConfig, $logger);
        });

        $this->app->bind(
            abstract: CategoryReadRepository::class,
            concrete: EloquentCategoryReadRepository::class
        );

        $this->app->bind(
            abstract: CourseReadRepository::class,
            concrete: EloquentCourseReadRepository::class
        );

        $this->app->bind(
            abstract: MediaFileRepository::class,
            concrete: EloquentMediaFileRepository::class
        );
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
