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
    Route::post('/user/{user}/volunteer-info', 'Admin\VolunteerInfoController@update')->name('user/volunteer-info/update');
    Route::get('/activities', 'ActivitiesController@index')->name('activities/index');

    Route::get('/activity/{activity}/participants', 'Admin\ActivitiesController@participants')->name('show/participants');
});


// Route for admin user
Route::middleware(['auth:'.config('admin-auth.defaults.guard')])->group(static function () {
    Route::delete('/user/{user}', 'Admin\UsersController@destroy')->name('user/destroy');
    Route::get('/clear-cache/application', function() {
        Artisan::call('cache:clear');
        return "Application cache cleared";
    });
    Route::get('/clear-cache/view', function() {
        Artisan::call('view:clear');
        return "View cache cleared";
    });
    Route::get('/clear-cache/config', function() {
        Artisan::call('config:clear');
        return "Config cache cleared";
    });

    Route::get('/activity/{activity}/budgets', 'Admin\ActivitiesController@budgets');
    Route::patch('/activity/{activity}/visibility', 'Admin\ActivitiesController@updateVisibility')->name('activity/visibility');

    Route::prefix('/activity/{activity}')->name('activity/budgets/')->group(static function() {
            Route::post('/budgets', 'Admin\BudgetsController@store')->name('store');
            Route::post('/budget/{budget}', 'Admin\BudgetsController@update')->name('update');
            Route::delete('/budget/{budget}', 'Admin\BudgetsController@destroy')->name('destroy');
    });
});



// Route for user only
Route::middleware(['auth:'.config('auth.defaults.guard')])->group(static function () {
    Route::patch('/activity/{activity}/participants', 'ActivitiesController@enroll')->name('activities/enroll');
    Route::post('/otp/enable', 'OTPController@enable');
    Route::post('/otp/verify', 'OTPController@verify');
});




