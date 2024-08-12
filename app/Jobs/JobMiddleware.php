<?php

namespace App\Jobs;

use Closure;
use Illuminate\Support\Facades\Redis;

class JobMiddleware
{
    /**
     * Process the queued job.
     *
     * @param  \Closure(object): void  $next
     */
    public function handle(object $job, Closure $next): void
    {
        Redis::throttle('meena')  // a special key
            ->block(0)   // wait for that much second if you dont get the lock
            ->allow(1)  // allow one instance to be run at a a time of neechy wala every
            ->every(2)    // for every this minute allow above one
            ->then(function () use ($job, $next) {
                // Lock obtained...

                $next($job);  // let the job run
            }, function () use ($job) {
                // Could not obtain lock...
                $job->release(15);  // add 15 minutes to the job ,, after this time that will be run
            });
    }
}
