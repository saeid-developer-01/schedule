<?php

namespace IICN\Schedule;

use IICN\Schedule\Services\Scheduler;
use Illuminate\Support\ServiceProvider;
use IICN\Schedule\Commands\RunSchedulerCommand;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                RunSchedulerCommand::class
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/schedule.php', 'schedule'
        );

        $this->app->bind('scheduler', function () {
            return new Scheduler();
        });
    }
}
