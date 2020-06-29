<?php

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
    return view('app');
});

Route::post('/api/login', 'Auth\LoginController@authenticate');
Route::get('/api/logout', 'Auth\LoginController@logout');

Route::prefix('/api/users')->group(function () {
    Route::post('password/reset-token', 'Auth\LoginController@sendResetPasswordEmail');
    Route::post('password/reset-token/verify', 'Auth\LoginController@verifyResetPasswordToken');
    Route::put('password', 'Auth\LoginController@resetPassword');
});

Route::get('/activities/{activity}/enroll/guest/{guest}', 'ActivityController@guestEnroll')->name('app.guest.enroll');

