<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin_api'])->group(function () {
    Route::get('/config', 'ConfigController@config');
    Route::get('/admin-users/current', 'AdminUserController@current');
    Route::put('/admin-users/current', 'AdminUserController@updateCurrent');
    Route::apiResource('admin-users', 'AdminUserController');
    Route::apiResource('roles', 'RoleController');
    Route::apiResource('permissions', 'PermissionController');
    Route::apiResource('audits', 'AuditController');
    Route::put('/roles/{roles}/permissions', 'RoleController@updatePermissions');
    Route::get('/file/disk-usage', 'FileController@getDiskUsage');
    Route::get('/file/collections', 'FileController@getCollections');

    // Anthurium Routes
    Route::apiResource('activities', 'ActivityController');
    Route::get('/activities/{activity}/participants', 'ActivityController@participants');
    Route::get('/activities/{activity}/statistics', 'ActivityController@statistics');
    Route::patch('/participation/{participation}', 'ParticipationController@update');

    Route::apiResource('users', 'UserController');
    Route::get('/users/{user}/participations', 'UserController@participations');

    Route::apiResource('guests', 'GuestController');

    // Form
    Route::apiResource('forms', 'FormController');
    Route::apiResource('forms.questions', 'FormQuestionController');
    Route::apiResource('forms.answers', 'FormAnswerController');
});

