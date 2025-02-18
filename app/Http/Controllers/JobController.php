<?php

namespace App\Http\Controllers;

use App\Jobs\CheckBatchTransactionJob;
use App\Jobs\CheckBatchTransactionJobSecond;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Throwable;

class JobController extends Controller
{
    //
    public int  $testVar = 1;
    public function batchtransactiontest()
    {

        $batch = Bus::batch([
            new CheckBatchTransactionJob(),
            new CheckBatchTransactionJobSecond(),

        ])->then(function (Batch $batch) {
            // All jobs completed successfully...
            // runs only if all the jobs run successfully
            Log::info("then block");
            Log::info($this->testVar);  // yhan tk woh instance ko pkr leta and variable b sahi print krta
            $this->testVar = 3;  // as we are updating it here and finally block is supposed to run after it but because jab job ka instance banta ya batch ko hm bnaty tu us time p is $this main jo hta woh db main chala jata tu wohi phr finally main available hoga. yeh updated nhe
        })->catch(function (Batch $batch, Throwable $e) {
            // First batch job failure detected...
            //runs only once
            Log::info("catch");
        })->finally(function (Batch $batch) {
            // The batch has finished executing...
            Log::info("finally");
            Log::info($this->testVar);  // yhan tk woh instance ko pkr leta and variable b sahi print krta

            $this->testMethod();
        })->dispatch();
    }

    private function testMethod()
    {

        Log::info("test method in this callback");
    }
}
