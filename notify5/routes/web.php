<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/user_login', [UserController::class, 'user_login'])->name('user_login');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/store_register', [UserController::class, 'store_register'])->name('store_register');

Route::group(['middleware' => 'auth.user'], function () {
    Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');
});

Route::post('save_task', [TaskController::class, 'save_task']);