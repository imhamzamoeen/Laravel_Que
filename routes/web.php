<?php

use App\Jobs\TestJob;
use App\Jobs\TestJobFail;
use App\Jobs\testStaticJob;
use App\Jobs\UniqueJob;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/testing-worker-instance',function(){



// the thing is that each worker is a seperate os process , that gets an instance of the app and runs the jobs.
// so theroratically it shuld have shared static things like each instance has for once .. mltb after app is bootstrapped. after the service providers . and other things like classes on calls run then after thier constructs etc

testStaticJob::dispatch();

// this queu uses a class that has a static variable tu hta ki h har worker k pas uska ek instance ban jata mtlb har worker k pas seperate static class rhi. and us instance ki har job k pas woh shared hoga
}
);


Route::get('/', function () {

    // try {

    //     $user =  User::with('books:id,user_id')->find(2);
    //     TestJob::dispatch($user);
    // } catch (Exception $e) {
    //     dd($e);
    // }

    $user =  User::with('books:id,user_id')->find(2);


    // Bus::chain([   // is main ek fail ho tu agli nhe chalti
    //     new TestJob($user),
    //     new TestJobFail($user),
    // ])->catch(function (Throwable $e) {
    //     Log::info("mar gai");
    // })->dispatch();   // is mian ek e entry hoti h jobs k table main and yeh 1 k bad 1 chalti hn .. 2sri wali pehly s oper nhe chal sakti and ek e worker chalata q h cz of reserved_at


    $batch = Bus::batch([
        new TestJobFail(User::find(1)),
        new TestJobFail(User::find(1)),
        new TestJob(User::find(2)),

    ])->then(function (Batch $batch) {
        // All jobs completed successfully...
        // runs only if all the jobs run successfully
        Log::info("then");
    })->catch(function (Batch $batch, Throwable $e) {
        // First batch job failure detected...
        //runs only once
        Log::info("catch");
    })->finally(function (Batch $batch) {
        // The batch has finished executing...
        Log::info("finally");
    })->dispatch();

    // // is mian ek e batchable waly table main entry hoti and jo us jobs ko fir jobs main b rkhta and woh multiple worker b chala sakty .. parallel main
    // is  mainagr job fail ho tu koi masla nhe .. woht chalta rehta.
    // is mian ek e batchable waly table main entry hoti and jo us jobs ko fir jobs main b rkhta and woh multiple worker b chala sakty .. parallel main
    // since batch ki har ek job ja k job table main jati and as normal job treat hoti so har option kam krta. but batch ko pta hota k meri job k sath ho kia rha


});
