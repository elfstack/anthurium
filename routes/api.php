<?php

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

// Route for both user and admin user
Route::middleware(['auth:'.config('auth.defaults.guard').','.config('admin-auth.defaults.guard')])->group(static function () {
    Route::post('/users', 'Admin\UsersController@store')->name('user/store');
    Route::post('/user/{user}', 'Admin\UsersController@update')->name('user/update');
    Route::get('/activities', 'ActivitiesController@index')->name('activities/index');
});


// Route for admin user
Route::middleware(['auth:'.config('admin-auth.defaults.guard')])->group(static function () {
    Route::delete('/user/{user}', 'Admin\UsersController@destroy')->name('user/destroy');
});


// Route for user only
Route::middleware(['auth:'.config('auth.defaults.guard')])->group(static function () {
    Route::patch('/activity/{activity}/participants', 'ActivitiesController@enroll')->name('activities/enroll');
});



