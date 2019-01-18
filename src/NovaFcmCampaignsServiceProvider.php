<?php

namespace Coreproc\NovaFcmCampaigns;

use Coreproc\NovaFcmCampaigns\Http\Middleware\Authorize;
use Coreproc\NovaFcmCampaigns\Models\FcmCampaign;
use Coreproc\NovaFcmCampaigns\Observers\FcmCampaignObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class NovaFcmCampaignsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-fcm-campaigns');

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'nova-fcm-campaigns-migrations');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            FcmCampaign::observe(FcmCampaignObserver::class);
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/nova-fcm-campaigns')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
