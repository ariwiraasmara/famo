<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/unprotected', function () {
//     // Konten rute yang tidak terproteksi
//     Route::post('/user/login', 'App\Http\Controllers\UserController@login');
//     Route::post('/user/create', 'App\Http\Controllers\UserController@register');
// });

Route::post('/user/login', 'App\Http\Controllers\UserController@login');
Route::get('/user/logout', 'App\Http\Controllers\UserController@logout');
Route::post('/user/create', 'App\Http\Controllers\UserController@register');

Route::middleware(App\Http\Middleware\EnsureTokenIsValid::class)->group(function() {
    Route::get('user/dashboard', 'App\Http\Controllers\UserController@dashboard');
    
    // Route::get('/user/find/{id}/{term}', 'App\Http\Controllers\UserController@search');
    Route::get('/user/file/all/{id}', 'App\Http\Controllers\UserFileController@index');
    Route::get('/user/find/{id}/{term}', 'App\Http\Controllers\UserController@search');
    Route::get('/user/file/{id}', 'App\Http\Controllers\UserFileController@show');
    Route::post('/user/file/store', 'App\Http\Controllers\UserFileController@store');
    Route::delete('/user/file/delete/{id}', 'App\Http\Controllers\UserFileController@destroy');

    Route::get('/member/confirmation/all/{id}', 'App\Http\Controllers\MemberConfirmationController@index');
    Route::post('/member/confirmation/store/', 'App\Http\Controllers\MemberConfirmationController@store');
    Route::post('/member/confirmation/update/', 'App\Http\Controllers\MemberConfirmationController@update');
    Route::post('/member/confirmation/reject/', 'App\Http\Controllers\MemberConfirmationController@reject');
    Route::delete('/member/confirmation/delete/{id}', 'App\Http\Controllers\MemberConfirmationController@destroy');
    Route::delete('/member/confirmation/delete/all/{id}', 'App\Http\Controllers\MemberConfirmationController@destroyAll');

    Route::get('/member/all/{id}', 'App\Http\Controllers\MyMemberController@index');
    Route::get('/member/recent/{id}', 'App\Http\Controllers\MyMemberController@recentMember');
    Route::get('/member/total/{id}', 'App\Http\Controllers\MyMemberController@totalMember');
    Route::get('/member/all/{id}/{order}/{by}', 'App\Http\Controllers\MyMemberController@allParentChildMember');
    Route::delete('/member/delete/{id}', 'App\Http\Controllers\MyMemberController@destroy');

    Route::get('/membership/all/{id}', 'App\Http\Controllers\MemberOfController@index');
    Route::get('/membership/recent/{id}', 'App\Http\Controllers\MyMemberController@recentMembership');
    Route::get('/membership/total/{id}', 'App\Http\Controllers\MyMemberController@totalMembership');
    Route::delete('/membership/delete/{id}', 'App\Http\Controllers\MemberOfController@destroy');
});

/*Route::middleware('auth:api')->group( function () {
    Route::get('/user/find/{id}/{term}', 'App\Http\Controllers\UserController@search');
    Route::get('/user/file/all/{id}', 'App\Http\Controllers\UserFileController@index');
    Route::get('/user/file/{id}', 'App\Http\Controllers\UserFileController@show');
    Route::post('/user/file/store', 'App\Http\Controllers\UserFileController@store');
    Route::delete('/user/file/delete/{id}', 'App\Http\Controllers\UserFileController@destroy');

    Route::get('/member/confirmation/all/{id}', 'App\Http\Controllers\MemberConfirmationController@index');
    Route::post('/member/confirmation/store/', 'App\Http\Controllers\MemberConfirmationController@store');
    Route::post('/member/confirmation/update/', 'App\Http\Controllers\MemberConfirmationController@update');
    Route::post('/member/confirmation/reject/', 'App\Http\Controllers\MemberConfirmationController@reject');
    Route::delete('/member/confirmation/delete/{id}', 'App\Http\Controllers\MemberConfirmationController@destroy');
    Route::delete('/member/confirmation/delete/all/{id}', 'App\Http\Controllers\MemberConfirmationController@destroyAll');

    Route::get('/member/all/{id}', 'App\Http\Controllers\MyMemberController@index');
    Route::get('/member/recent/{id}', 'App\Http\Controllers\MyMemberController@recentMember');
    Route::get('/member/total/{id}', 'App\Http\Controllers\MyMemberController@totalMember');
    Route::get('/member/all/{id}/{order}/{by}', 'App\Http\Controllers\MyMemberController@allParentChildMember');
    Route::delete('/member/delete/{id}', 'App\Http\Controllers\MyMemberController@destroy');

    Route::get('/membership/all/{id}', 'App\Http\Controllers\MemberOfController@index');
    Route::get('/membership/recent/{id}', 'App\Http\Controllers\MyMemberController@recentMembership');
    Route::get('/membership/total/{id}', 'App\Http\Controllers\MyMemberController@totalMembership');
    Route::delete('/membership/delete/{id}', 'App\Http\Controllers\MemberOfController@destroy');
});*/

// Route::get('/user/file/all/{id}', 'App\Http\Controllers\UserFileController@index');

