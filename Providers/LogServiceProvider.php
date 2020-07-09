<?php

namespace BRCas\Log\Providers;

use BRCas\Log\Console;
use Illuminate\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Log';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'log';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
        $this->registerPublishing();
        $this->registerMigrations();

        $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');
        $kernel->pushMiddleware(\BRCas\Log\Middleware\LogMiddleware::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php',
            'brcaslog'
        );
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../Config/config.php' => config_path('brcaslog.php'),
            ], 'brcas-log-config');
        }
    }

    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function registerMigrations()
    {
        if ($this->app->runningInConsole() && $this->shouldMigrate()) {
            $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        }
    }

    /**
     * Determine if we should register the migrations.
     *
     * @return bool
     */
    protected function shouldMigrate()
    {
        return config('brcaslog.driver') === 'database';
    }

    public function register()
    {
        $this->commands([
            Console\InstallCommand::class,
        ]);
    }
}
