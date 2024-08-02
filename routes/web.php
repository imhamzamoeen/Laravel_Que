<?php

use App\Jobs\TestJob;
use App\Jobs\TestJobFail;
use App\Jobs\UniqueJob;
use App\Models\User;
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

Route::get('/', function () {


    $user =  User::find(1);


    TestJobFail::dispatch($user);




    // Bus::chain([   // is main ek fail ho tu agli nhe chalti
    //     new TestJob($user),
    //     new TestJobFail($user),
    // ])->dispatch();   // is mian ek e entry hoti h jobs k table main and yeh 1 k bad 1 chalti hn .. 2sri wali pehly s oper nhe chal sakti and ek e worker chalata q h cz of reserved_at


// $batch = Bus::batch([
//        new TestJob( User::find(1)),
//         new TestJob( User::find(2)),
// ])->then(function ( $batch) {
//     // All jobs completed successfully...
//     Log::info("then");
// })->catch(function ( $batch, Throwable $e) {
//     Log::info("catch");
//     // This callback is only invoked for the first job that fails within the batch.

// })->finally(function ( $batch) {
//     Log::info("finally");


// })->dispatch();

// // is mian ek e batchable waly table main entry hoti and jo us jobs ko fir jobs main b rkhta and woh multiple worker b chala sakty .. parallel main


});


