<?php

namespace Oness\Sincontrol;
use Illuminate\Support\ServiceProvider;

/**
 * This is the FacturaServiceProvider class.
 *
 * @author Roger Leon <rhleone@gmail.com>
 */
class FacturaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Templates', 'sincontrol');

        $this->publishes([
            __DIR__.'/Templates'           => resource_path('views/vendor/sincontrol'),
            __DIR__.'/Config/sincontrol.php' => config_path('sincontrol.php'),
        ], 'sincontrol');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/Config/sincontrol.php', 'sincontrol'
        );
        setlocale(LC_TIME, config('app.locale'));
    }
}