<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\WebhookDispatched;
use App\Listeners\DispatchWebhookJob;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            WebhookDispatched::class,
            DispatchWebhookJob::class
        );

        Route::prefix('api/v1')
        ->middleware('api')
        ->group(base_path('routes/api/v1.php'));
    }
}
