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

Route::get('/', function () {
    return view('welcome');
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::get('/', function () {
            return view('admin.dashboard');
        });
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('users')->name('users/')->group(static function() {
            Route::get('/',                                             'UsersController@index')->name('index');
            Route::get('/create',                                       'UsersController@create')->name('create');
            Route::post('/',                                            'UsersController@store')->name('store');
            Route::get('/{user}/edit',                                  'UsersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'UsersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{user}',                                      'UsersController@update')->name('update');
            Route::delete('/{user}',                                    'UsersController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('volunteer-infos')->name('volunteer-infos/')->group(static function() {
            Route::get('/',                                             'VolunteerInfoController@index')->name('index');
            Route::get('/create',                                       'VolunteerInfoController@create')->name('create');
            Route::post('/',                                            'VolunteerInfoController@store')->name('store');
            Route::get('/{volunteerInfo}/edit',                         'VolunteerInfoController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'VolunteerInfoController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{volunteerInfo}',                             'VolunteerInfoController@update')->name('update');
            Route::delete('/{volunteerInfo}',                           'VolunteerInfoController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('activities')->name('activities/')->group(static function() {
            Route::get('/',                                             'ActivitiesController@index')->name('index');
            Route::get('/create',                                       'ActivitiesController@create')->name('create');
            Route::post('/',                                            'ActivitiesController@store')->name('store');
            Route::get('/{activity}/edit',                              'ActivitiesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ActivitiesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{activity}',                                  'ActivitiesController@update')->name('update');
            Route::delete('/{activity}',                                'ActivitiesController@destroy')->name('destroy');
        });
    });
});