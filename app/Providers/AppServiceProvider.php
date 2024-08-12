<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;

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
        RateLimiter::for('jobMiddleware', function (object $job) {
            return $job->user->id == 1 ? Limit::none() : Limit::perMinute(1)->by($job->user->id);
        });

        Queue::before(function (JobProcessing $event) {
            // Log::info("beofer"); // every time before dispatching
            // $event->connectionName
            // $event->job
            // $event->job->payload()
        });

        Queue::after(function (JobProcessed $event) {
            // Log::info("after");   // when a job gets proccessed as passed

            // $event->connectionName
            // $event->job
            // $event->job->payload()
        });

        Queue::failing(function (JobFailed $event) {
            // Log::info("JobFailed");    // whenever a job gets failed and moved to failed job or pki wali fail yani red wali fail
            // $event->connectionName
            // $event->job
            // $event->exception
        });
    }
}
