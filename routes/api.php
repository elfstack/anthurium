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

Route::get('/config', 'ConfigController@config');

Route::apiResource('activities', 'ActivityController');
Route::apiResource('participations', 'ParticipationController');
Route::get('/participations/{participation}/otp', 'ParticipationController@otp');
Route::post('/activities/{activity}/enroll', 'ActivityController@enroll');
Route::post('/activities/{activity}/participation/{participation}/check-out', 'ActivityController@checkOut');

Route::get('/users/{user}/participations', 'ParticipationController@index');
Route::apiResource('users', 'UserController')->only(['show', 'store', 'update']);
Route::apiResource('forms.questions', 'FormQuestionController');
Route::post('/data-collection/{dataCollection}/response', 'FormQuestionController@store');

Route::get('/action', 'ActionController@findAction');
Route::apiResource('action', 'ActionController')->only(['update']);
