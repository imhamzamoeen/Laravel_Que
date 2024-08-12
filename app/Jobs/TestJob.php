<?php

namespace App\Jobs;

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

class TestJob implements ShouldQueue
{

    public $user;
    /*
    ShouldBeUnique ->  is job ka 1 hi instance at a time jobs table main  prha ho even agr ziada worker hn tu b..  is mian yehi hota k cache main check krta and lock gain krta kuch time k lie.. agr nah mily tu woh job table main enter nhe krta
    ShouldBeEncrypted ->  yeh ap k job k data yani payload etc ko encrypt kr k store krti and jab chalti tu khud e theek kr leti
    whenever a timeout happens, the worker is killed , abd woh job jobs k table main e rehti ta k koi dosra worker attempt kr saky  but failontimeout s hm change kr sakty
    we have some events in app service provider that can be used to for monitoring
    created_at jis time job create hui
    available_at if we use delay with dispatch and releaseafter configration
    reserved_at is when a worker picks up the job so he sets it to the timestamp and no other can pick it up
    jo retry_after hota h woh utny seconds bad is reserved_at ko null kr deta h ta k koi aur b isy shru kr dy
    */
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, InteractsWithQueue, Batchable;
    // public $failOnTimeout = true;   // when the timeout happens, instead of keeping the job in the jobs table, send it to failed jobs tablle

    // public $timeout = 15;   // is time main agr nhe finsh hoti job tu queueu worker band kr do ..only works in ubuntu
    // this timeout is new  for each try


    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    // public $uniqueFor = 3600;   // inty seconds k lie unique.. is mian nhe khatma hoti tu behsak dosri b chala do

    // /**
    //  * Get the unique ID for the job.
    //  */
    // public function uniqueId(): string
    // {
    //     return $this->user->id;   // is id k dheko and is job ko unique consider kro
    // }


    /**
     * Create a new job instance.
     */
    /**
     * The number of times the job may be attempted... agr hm n tries di hn 5 tu iska mtlb ek job 5 bar chaly gi incase exception ati ya fail hoti tu .. usky bad isko failed jobs main bheja jai ga
     *
     * @var int
     */
    // public $tries = 12;     // itny tries k bad jab fail hogi tu woh mark as failed  e hogi // yani k 3rsi p fail krdo

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    // public $backoff = 10;

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    // public function backoff(): array     // variable and functoin k case mian variable ki priority hoti
    // {
    //     // return 3;
    //     return [1, 5, 10];          // 1 second for first time backoff  ,3 for second and so on
    // }
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(10);
        // //  incase of try catch , apki exception catch main pkri jati and job fail nhe hoti khtam ho jati
        // try{
        //     throw new \Exception('Something went wrong!');
        //     echo "Executing";
        //     echo $this->user->id;
        // }
        // catch(Exception $e){
        //     echo $e->getMessage();
        // }
        // sleep(6);
        // throw new \Exception('Something went wrong!');
        echo "Executing";
        echo $this->user;
    }


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
    public $maxExceptions = 4;   // maximum number of unhandled exceptions to allow before failing out .. this work with tries. on those tries these number of exceptions are allowed



    /* we can assign job middleware to any queueable */

    // public function middleware(): array
    // {
    //     // rate limitter is k us ky instance ap k given time main chal sakty like 1 minute main 2 chal rhi hon but for withoutoverlapping is like 1 at a time and agr dosra at tu kia krna
    //     Log::info("queue Middleware");
    //     // return [new JobMiddleware];   // the name of middleware we defined as a class like route middleware  ...
    //     // also hm boot main ek rate limiter bna sakty us ko job ka object pass hota and woh Limiter reutrn krsakta jo hm yhan use kr sakty
    //     //as    backups would be name of that ratelimmiter

    //     // return [new RateLimited('jobMiddleware')];  // the name of middleware we defined as a class like route middleware  ...

    //     return [(new WithoutOverlapping($this->user->id))->releaseAfter(60)]; // this can be used k agr is order ki id ki koi aur job ati tu woh nah chaly , at a time ek e resource manipulate ho
    // }

    public function failed()
    {
        // runs when a job is marked as faild and being sent to failed jobs
        echo "fail";
    }
}
