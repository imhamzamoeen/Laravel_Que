<?php

namespace App\Jobs;

use App\Classes\TestStaticClass;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;


class testStaticJob implements ShouldQueue
{

use Dispatchable;
    public function __construct()
    {

        echo 'constructor called';
    }


    public function handle()
    {

        echo 'handle called';
        sleep(10);
        echo "current counter is : " . TestStaticClass::$counter++;
        return 1;
    }
}
