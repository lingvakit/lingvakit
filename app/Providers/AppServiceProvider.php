<?php
declare(strict_types=1);

namespace App\Providers;

use App\Infrastructure\Persistence\QueryBuilder\LegacyQuestionAggregateFactory;
use App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy\BooleanChoiceMappingStrategy;
use App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy\FreeTextMappingStrategy;
use App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy\SentenceBuildMappingStrategy;
use App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy\FillInBlankMappingStrategy;
use App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy\MatchMappingStrategy;
use App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy\SingleChoiceMappingStrategy;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return null;
        });

        $this->app->tag([
            BooleanChoiceMappingStrategy::class,
            FreeTextMappingStrategy::class,
            SentenceBuildMappingStrategy::class,
            FillInBlankMappingStrategy::class,
            MatchMappingStrategy::class,
            SentenceBuildMappingStrategy::class,
            SingleChoiceMappingStrategy::class,
        ], 'question.mapping.strategies');

        $this->app->bind(LegacyQuestionAggregateFactory::class, function ($app) {
            return new LegacyQuestionAggregateFactory(
                $app->tagged('question.mapping.strategies')
            );
        });
    }

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
