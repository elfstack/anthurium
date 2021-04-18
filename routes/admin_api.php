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
    Route::apiResource('user_groups', 'UserGroupController');
    Route::apiResource('activities', 'ActivityController');
    Route::apiResource('activities.budgets', 'BudgetController');
    Route::get('/activities/{activity}/participants', 'ActivityController@participants');
    Route::get('/activities/{activity}/statistics', 'ActivityController@statistics');
    Route::patch('/participation/{participation}', 'ParticipationController@update');

    Route::apiResource('users', 'UserController');
    Route::get('/users/{user}/participations', 'UserController@participations');

    // Form
    Route::apiResource('data-collection', 'DataCollectionController');
    Route::apiResource('forms', 'FormController');
    Route::apiResource('forms.questions', 'FormQuestionController');
    // TODO: the following form routes also have to be changed
   // Route::apiResource('forms.answers', 'FormAnswerController');
    Route::apiResource('data-collection.responses', 'DataCollectionResponseController');
    Route::get('/data-collections/{dataCollection}/users/{user}/answers', 'DataCollectionResponseController@getResponseByUserId');
    Route::get('/users/{user}/member-form-answers', 'DataCollectionResponseController@getMemberFormResponseByUserId');

    // Config
    Route::patch('/config', 'ConfigController@update');
    Route::get('/config/{group}', 'ConfigController@getConfigGroup');

    // Action
    Route::apiResource('actions', 'ActionController');

    // Metrics
    Route::get('/metrics', 'MetricsController@index');
});

