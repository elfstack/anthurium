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


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('users')->name('users/')->group(static function() {
            Route::get('/',                                             'UsersController@index')->name('index');
            Route::get('/create',                                       'UsersController@create')->name('create');
            Route::get('/{user}/edit',                                  'UsersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'UsersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{user}/volunteer-info',                             'VolunteerInfoController@update')->name('update');
            Route::get('/gates', function () {
                return Gate::has('admin.user.edit') ? 'has' : 'hasnt';
            });

        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('volunteer-infos')->name('volunteer-infos/')->group(static function() {
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('activities')->name('activities/')->group(static function() {
            Route::get('/',                                             'ActivitiesController@index')->name('index');
            Route::get('/{activity}/participants',                                             'ActivitiesController@participants')->name('show/participants');
            Route::get('/create',                                       'ActivitiesController@create')->name('create');
            Route::post('/',                                            'ActivitiesController@store')->name('store');
            Route::get('/{activity}',                              'ActivitiesController@show')->name('show');
            Route::get('/{activity}/checkin',                              'ActivitiesController@checkin')->name('checkin');
            Route::get('/{activity}/checkin/otp',                              'ActivitiesController@checkinOtp')->name('checkin/otp');
            Route::get('/{activity}/edit',                              'ActivitiesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ActivitiesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{activity}',                                  'ActivitiesController@update')->name('update');
            Route::delete('/{activity}',                                'ActivitiesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('attendances')->name('attendances/')->group(static function() {
            Route::get('/',                                             'AttendanceController@index')->name('index');
            Route::get('/create',                                       'AttendanceController@create')->name('create');
            Route::post('/',                                            'AttendanceController@store')->name('store');
            Route::get('/{attendance}/edit',                            'AttendanceController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AttendanceController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{attendance}',                                'AttendanceController@update')->name('update');
            Route::delete('/{attendance}',                              'AttendanceController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('participants')->name('participants/')->group(static function() {
            Route::get('/',                                             'ParticipantsController@index')->name('index');
            Route::get('/create',                                       'ParticipantsController@create')->name('create');
            Route::post('/',                                            'ParticipantsController@store')->name('store');
            Route::get('/{participant}/edit',                           'ParticipantsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ParticipantsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{participant}',                               'ParticipantsController@update')->name('update');
            Route::delete('/{participant}',                             'ParticipantsController@destroy')->name('destroy');
        });
    });
});


Route::get('/activity/{activity}', 'ActivitiesController@show')->name('activities/show');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/profile', 'Auth\ProfileController@profile')->name('profile');

Route::get('/activity/{activity}/checkin', 'ActivitiesController@checkin')->name('activities/checkin');

Route::get('/activity/{activity}/enroll', 'ActivitiesController@enroll')->name('activities/enroll');

Route::get('/activities', 'ActivitiesController@index')->name('activities/index');

