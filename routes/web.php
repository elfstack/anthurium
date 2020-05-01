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
Route::get('/activity/{activity}', 'ActivitiesController@show')->name('activities/show');

Auth::routes(['verify' => true]);

Route::middleware(['auth:' . config('auth.defaults.guard')])->group(static function () {
    Route::get('/', function () {
        if (Auth::user()) {
            return redirect('/dashboard');
        }
    });
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



/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('budget-categories')->name('budget-categories/')->group(static function() {
            Route::get('/',                                             'BudgetCategoriesController@index')->name('index');
            Route::get('/create',                                       'BudgetCategoriesController@create')->name('create');
            Route::post('/',                                            'BudgetCategoriesController@store')->name('store');
            Route::get('/{budgetCategory}/edit',                        'BudgetCategoriesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'BudgetCategoriesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{budgetCategory}',                            'BudgetCategoriesController@update')->name('update');
            Route::delete('/{budgetCategory}',                          'BudgetCategoriesController@destroy')->name('destroy');
        });
    });
});




/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('roles')->name('roles/')->group(static function() {
            Route::get('/',                                             'RolesController@index')->name('index');
            Route::get('/create',                                       'RolesController@create')->name('create');
            Route::post('/',                                            'RolesController@store')->name('store');
            Route::get('/{role}/edit',                                  'RolesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'RolesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{role}',                                      'RolesController@update')->name('update');
            Route::delete('/{role}',                                    'RolesController@destroy')->name('destroy');
        });
    });
});