<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Libraries\jsr;
use App\Libraries\myfunction;
use Spatie\Csp\AddCspHeaders;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::get('/', 'App\Http\Controllers\ViewController@index')->name('index');
Route::get('/checklogin', 'App\Http\Controllers\ViewController@viewchecklogin')->name('checklogin');
Route::get('/debug/memberchild', 'App\Http\Controllers\DebugController@memberchild')->name('debug');

Route::get('/dashboard', 'App\Http\Controllers\ViewController@dashboard')->name('dashboard');
Route::get('/mymember', 'App\Http\Controllers\ViewController@mymember')->name('mymember');
Route::get('/memberof', 'App\Http\Controllers\ViewController@memberof')->name('memberof');
Route::get('/profile', 'App\Http\Controllers\ViewController@profile')->name('profile');
Route::get('/notification/all', 'App\Http\Controllers\ViewController@allnotification')->name('notifications');
Route::get('/logout', 'App\Http\Controllers\UserController@logout_web')->name('logout');

Route::get('/redis', 'App\Http\Controllers\RedisController@index');

/* 
Route::middleware(AddCspHeaders::class)->group(function () {
    // Routes go here...
    Route::get('/', 'App\Http\Controllers\ViewController@index')->name('index');
    Route::get('/checklogin', 'App\Http\Controllers\ViewController@viewchecklogin')->name('checklogin');
    Route::get('/dashboard', 'App\Http\Controllers\ViewController@dashboard')->name('dashboard');
    Route::get('/mymember', 'App\Http\Controllers\ViewController@mymember')->name('mymember');
    Route::get('/memberof', 'App\Http\Controllers\ViewController@memberof')->name('memberof');
    Route::get('/profile', 'App\Http\Controllers\ViewController@profile')->name('profile');
    Route::get('/notification/all', 'App\Http\Controllers\ViewController@allnotification')->name('notifications');
    Route::get('/logout', 'App\Http\Controllers\UserController@logout_web')->name('logout');
});



Route::get('/unprotected', function () {
    // Konten rute yang tidak terproteksi
    Route::get('/', 'App\Http\Controllers\ViewController@index')->name('index');
    Route::get('/checklogin', 'App\Http\Controllers\ViewController@viewchecklogin')->name('checklogin');
});

Route::middleware('role:1,2,3')->group(function () {
    Route::get('/secure', function () {
        // Konten rute yang terproteksi
        Route::get('/dashboard', 'App\Http\Controllers\ViewController@dashboard')->name('dashboard');
        Route::get('/mymember', 'App\Http\Controllers\ViewController@mymember')->name('mymember');
        Route::get('/memberof', 'App\Http\Controllers\ViewController@memberof')->name('memberof');
        Route::get('/profile', 'App\Http\Controllers\ViewController@profile')->name('profile');
        Route::get('/notification/all', 'App\Http\Controllers\ViewController@allnotification')->name('notifications');
        Route::get('/logout', 'App\Http\Controllers\UserController@logout_web')->name('logout');
    });
});
*/


require __DIR__.'/auth.php';
