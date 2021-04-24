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
    Route::patch('/users/current', 'UserController@updateCurrent');
    // anthurium routes
    Route::post('/activities/{activity}/enroll', 'ActivityController@enroll');
    Route::apiResource('participations', 'ParticipationController');
    Route::get('/users/{user}/participations', 'ParticipationController@index');

    Route::apiResource('notifications', 'NotificationController');
    Route::put('notifications', 'NotificationController@markSelectedAsRead');
    Route::delete('notifications', 'NotificationController@destroySelected');

    Route::apiResource('data-collection', 'DataCollectionController');
    Route::post('/data-collection/{dataCollection}/response', 'FormQuestionController@store');
});
Route::get('/data-collection-response/{dataCollectionResponse}', 'DataCollectionController@showResponse');
Route::get('/config', 'ConfigController@config');

Route::apiResource('activities', 'ActivityController');
// Route::get('/participations/{participation}/otp', 'ParticipationController@otp');
// Route::post('/activities/{activity}/participation/{participation}/check-out', 'ActivityController@checkOut');

Route::apiResource('users', 'UserController')->only(['show', 'store']);
// Route::apiResource('forms.questions', 'FormQuestionController');

// Route::get('/action', 'ActionController@findAction');
// Route::apiResource('action', 'ActionController')->only(['update']);
