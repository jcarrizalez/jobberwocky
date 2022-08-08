<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Avature\Services\Authentications\ContextService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Context', fn() => new ContextService(app(\Illuminate\Http\Request::class)));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
