<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class RateLimited
{
    /**
     * Process the queued job.
     *
     * @param  \Closure(object): void  $next
     */
    public function handle(object $job, Closure $next): void
    {
        /* 60 seconds main kisi b queueu worker k pas is job ka 1 e instance chal rha ho .. agr dosra ata h tu usko lock nhe mily ga and uska attempt increase kr k usky available at main yeh time add kr dia jata h release after wala */
        Redis::throttle('job')
            ->block(0)->allow(1)->every(60)
            ->then(function () use ($job, $next) {
                // Lock obtained...
                Log::info("lock obtained" . json_encode($job));
                $next($job);
            }, function () use ($job) {
                // Could not obtain lock...
                Log::info("lock  nhe mila ");

                $job->release(30);
            });
    }
}
