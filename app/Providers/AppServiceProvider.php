<?php

namespace App\Providers;

use App\Http\Routing\ApiResourceRegister;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Routing\ResourceRegistrar;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Event::listen(MigrationsStarted::class, function () {
            DB::statement('SET SESSION sql_require_primary_key=0');
        });

        Event::listen(MigrationsEnded::class, function () {
            DB::statement('SET SESSION sql_require_primary_key=1');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        $register = new ApiResourceRegister($this->app['router']);
        $this->app->bind(ResourceRegistrar::class, static function () use ($register) {
            return $register;
        });

        if (app()->environment() !== 'local'):
            $url->forceScheme('https');
        endif;
    }
}
