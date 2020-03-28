<?php

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
Auth::routes(['verify' => true]);

Route::middleware(['auth:' . config('auth.defaults.guard')])->group(static function () {
    Route::get('/', function () {
        if (Auth::user()) {
            return redirect('/dashboard');
        }
    });
    Route::get('/activity/{activity}', 'ActivitiesController@show')->name('activities/show');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/notifications', 'NotificationController@index')->name('notifications');
    Route::get('/profile', 'Auth\ProfileController@profile')->name('profile');
    Route::get('/security', 'Auth\ProfileController@security')->name('security');
    Route::get('/settings', 'SettingsController@settings')->name('settings');
    Route::get('/activity/{activity}/checkin', 'ActivitiesController@checkin')->name('activities/checkin');
    Route::get('/activity/{activity}/checkout','ActivitiesController@checkout')->name('activities/checkout');
});


// FIXME: not working
Route::middleware(['auth:' . config('auth.defaults.guard') .','.config('admin-auth.defaults.guard')])->group(static function () {
    Route::post('upload', 'FileUploadController@upload')->name('brackets/media::upload');
    Route::namespace('\Brackets\Media\Http\Controllers')->group(static function () {
        Route::get('view', 'FileViewController@view')->name('brackets/media::view');
    });
});

