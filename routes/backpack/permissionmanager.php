<?php

Route::group([
	'namespace'  => 'App\Http\Controllers\Admin',
	'prefix'     => config('backpack.base.route_prefix', 'admin'),
	'middleware' => ['web', 'admin', 'isAdmin'],
], function () {
	CRUD::resource('user', 'UserCrudController');
});

Route::group([
	'namespace'  => 'Backpack\PermissionManager\app\Http\Controllers',
	'prefix'     => config('backpack.base.route_prefix', 'admin'),
	'middleware' => ['web', 'admin'],
], function () {
	CRUD::resource('permission', 'PermissionCrudController');
	CRUD::resource('role', 'RoleCrudController');
});

