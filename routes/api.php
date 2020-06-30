<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/media/upload', 'FileController@upload');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/users/current', 'UserController@current');
    // anthurium routes
});

Route::apiResource('activities', 'ActivityController');
Route::apiResource('participations', 'ParticipationController');
Route::post('/activities/{activity}/enroll', 'ActivityController@enroll');
Route::post('/activities/{activity}/participation/{participation}/check-out', 'ActivityController@checkOut');
