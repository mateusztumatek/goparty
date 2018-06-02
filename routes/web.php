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

Route::get('/send', 'HomeController@send');

/* ====== HOME PAGE ====== */
Route::get( '/', 'HomeController@index' )->name( 'home' );
Route::get( '/home', 'HomeController@index' )->name( 'home' );
/* ====== END OF HOME PAGE ====== */

/* ====== AUTH ====== */
Auth::routes();
Route::get( '/register', 'Auth\RegisterController@getRegister' )->name( 'register' );
/* ====== END OF AUTH ====== */

/* ====== USERS ====== */
Route::group( [ 'namespace' => 'User', 'middleware' => [ 'auth' ] ], function () {
	/* Rotes for auth users (show other users and manage your account) */
	Route::resource( '/users', 'UsersController', [ 'except' => [ 'create', 'store' ] ] );
	/* Rotes for auth user showing dashboard panel */
	Route::get( '/dashboard', 'UserDashboardController@index' )->name( 'user-dashboard.index' );;
} );
/* ====== END OF USERS ====== */

/* ====== CLUBS ====== */
/* Middleware is declarate in controller!!! */
Route::namespace('Clubs')->group(function () {

	/* Rotes for clubs on guest/user front end portal (for all visitors) */
	Route::resource( 'clubs', 'ClubsUserController', [ 'except' => [ 'edit', 'update', 'destroy' ] ] );

	/* Rotes for clubs on owner dashboard panel (role: owner) */
	Route::prefix('dashboard')->group(function () {
		Route::resource( 'clubs', 'ClubsOwnerController');
		Route::get('clubs/{club}/club-events', 'ClubsOwnerController@clubEvents')->name('club-events');
	} );

} );
/* ====== END OF CLUBS ====== */
/* ====== Images ======= */
Route::post('/club/image/', 'ClubImageController@store')->name('clubImage.store');
Route::post('/clubImage/delete', 'ClubImageController@destroy')->name('clubImage.delete');
Route::post('/clubImage/active', 'ClubImageController@changeActive')->name('clubImage.changeActive');
Route::post('/clubImage/main', 'ClubImageController@changeMain')->name('clubImage.changeMain');
/* ====== End Images ======= */
/* ====== EVENTS ====== */
/* Middleware is declarate in controller!!! */
Route::namespace('Events')->group(function () {

	/* Rotes for events on guest/user front end portal (for all visitors) */
	Route::get('events', 'EventsUserController@allEvents')->name('all-events');
//	Route::get('clubs/{club}/events', 'EventsUserController@clubEvents')->name('club-events');
	Route::get('events/{event}', 'EventsUserController@singleEvent')->name('single-event');

	Route::get('search-events', 'EventsUserController@searchEvents');

	/* Rotes for events on owner dashboard panel (role: owner) */
	Route::prefix('dashboard')->group(function () {
		Route::get('owner-all-events', 'EventsOwnerController@index')->name('all-owner-events');
		Route::resource( 'clubs/{club}/events', 'EventsOwnerController', [ 'except' => [ 'index' ] ]);
	} );

} );
/* ====== END OF EVENTS ====== */

/* Routes for administration panel (role: admin) - LARAVEL BACKPACK CRUD */
Route::group( [ 'prefix' => 'admin', 'middleware' => [ 'isAdmin' ], 'namespace' => 'Admin' ], function () {
	CRUD::resource( 'music-types', 'MusicTypesCrudController' );
	CRUD::resource( 'cities', 'CitiesCrudController' );
	CRUD::resource( 'clubs', 'ClubsCrudController' );
} );

Route::get('search/autocomplete', 'SearchController@autocomplete');
Route::get('search/clubs', 'SearchController@search_clubs');

Route::post('take-part', 'Events\EventsUserController@takePart');
Route::get('take-part', 'API\EventsController@checkIfExistAttendance');





