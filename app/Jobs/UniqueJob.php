<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UniqueJob implements ShouldQueue,ShouldBeUnique
{

    /* it should implement ShouldBeUniqueUntilProcessing if ap n processing s pehly e job ka unqieuness khatma krna */

    /* should be unique main agr koi job worker mian pari vi h  tu woh worker tk jati e nhe h */
    /* like db main agr koi pari vi user id 1 ki job tu agr wohi job us k lie dobara jati tu woh leta e neh h  .. uski db main entry e nhe hoti*/
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;
    /**
     * Create a new job instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info($this->user);
        echo "Executing";
    }

    public $uniqueFor = 5;  // agr is time tk job complete nhe hoti after dispatching tu iska uniqueness khatma kr do

    public function uniqueId(): string
    {
        // wsy isky beghair b manage ho jata h .. woh khud e smbhal leta h uniquness */
        /* manually specifyint the unique id for the job ta k is id ki koi aur job nah chaly jab tk isky pas lock */
        return $this->user->id;
    }

    public function uniqueVia()
    {
        /* by default jab ek unique job dispatch hona chahti tu woh is cache driver k thorugh check kry gi lock ko.. agr yeh method nah ho tu default cache driver ko use kry gi */
        return Cache::driver('redis');
    }
}
