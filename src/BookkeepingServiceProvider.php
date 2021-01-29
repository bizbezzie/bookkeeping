<?php

namespace BizBezzie\Bookkeeping;

use Illuminate\Support\ServiceProvider;

class BookkeepingServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'bizbezzie');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'bizbezzie');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
        $this->app->bind('Bookkeeping', function ($app) {
            return new Bookkeeping();
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bookkeeping.php', 'bookkeeping');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php',);

        // Register the service the package provides.
        $this->app->singleton('bookkeeping', function ($app) {
            return new Bookkeeping;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['bookkeeping'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/bookkeeping.php' => config_path('bookkeeping.php'),
        ], 'bookkeeping.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/bizbezzie'),
        ], 'bookkeeping.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/bizbezzie'),
        ], 'bookkeeping.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/bizbezzie'),
        ], 'bookkeeping.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
