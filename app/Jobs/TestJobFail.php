<?php

namespace App\Jobs;

use App\Http\Middleware\RateLimited as MiddlewareRateLimited;
use App\Models\User;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TestJobFail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, InteractsWithQueue, Batchable;

    public $user;
    public function __construct($user)
    {
        $this->user = $user;
    }


    // public $timeout = 15;   // is tiome main agr nhe finsh hoti job tu queueu worker band kr do


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(5);
        throw new Exception('Job failed');
    }

    // public $backoff = 10;

    public $tries = 3;

    /**
     * Determine the time at which the job should timeout.  jab b worker usy pkry ga tb s agy given time tk yeh retry hogi usky bad marked as fial hogi
     * and $tries and retryuntil main retry until ki priority ziada h
     */
    // public function retryUntil()
    // {
    //     return now()->addMinutes(10);
    // }

    /**
     * The maximum number of unhandled exceptions to allow before failing.  is s ziada exception jab b yeh job dy isy dhaky mar k failed jobs main bhej do behsak tries rehti ho ya retry until
     *
     * @var int
     */
    // public $maxExceptions = 3;



    // public function middleware(): array
    // {
    //     return [new \App\Http\Middleware\RateLimited];
    // }


    public function failed()
    {
        // runs when a job is marked as faild and being sent to failed jobs
        echo "fail";
    }
}
