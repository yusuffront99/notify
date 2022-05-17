<?php

use App\Events\ChatEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('send', function(Request $request){
    $request->validate([
        'name' => 'required',
        'message' => 'required'
    ]);

    $message = [
        'name' => $request->name,
        'message' => $request->message,
    ];

    ChatEvent::dispatch($message);
})->name('send');