<?php

namespace App\Jobs;

use App\Classes\TestStaticClass;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class testStaticJob implements ShouldQueue
{

    use Dispatchable;
    public function __construct()
    {
        echo 'constructor called';
    }


    public function handle(TestStaticClass $object)
    {
        // Cache::put('test', 'hamza');   // same for cache... only array driver is seperate for each worker baqi shared hn
        // // bcz this is singleton class so each worker will have one instance of this class for all jobs
        // echo 'handle called';
        // sleep(seconds: 39);
        // echo "current counter is : " . $object->count++;
        sleep(seconds: 39);

     echo   Cache::get('test', '');
        return 1;
    }
}
