<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
        (array)config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::middleware("super")->group(function () {
        Route::crud('staff', 'StaffCrudController');

        Route::crud('post', 'PostCrudController');
    });
    Route::middleware("staff")->group(function () {
        Route::crud('user', 'UserCrudController');
        Route::crud('student', 'StudentCrudController');
        Route::crud('teacher', 'TeacherCrudController');
    });
    Route::crud('grade', 'GradeCrudController');
    Route::crud('log', 'LogCrudController');

    Route::crud('customer', 'CustomerCrudController');
}); // this should be the absolute last line of this file
