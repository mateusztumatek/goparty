<?php

namespace App\Http\Controllers\Events;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EventsOwnerController extends Controller {

	public function __construct() {

		/* Check if user has owner role*/
		$this->middleware( 'role:owner' );

		$this->middleware( 'event_permission', [ 'except' => [ 'index' ] ] );

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$events = Event::with( 'club' )->where( 'user_id', Auth::id() )->get();

		return view( 'dashboard.events.index', compact( 'events' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param Club $club
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create( Club $club ) {
		return view( 'dashboard.events.create', compact( 'club' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		Event::create( $request->all() );

		return redirect()->route( 'club-events', [ 'club_id' => $request->club_id ] );
	}

	/**
	 * Display the specified resource.
	 *
	 * @return void
	 */
	public function show() {
		echo 'owner.show.event';
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Club $club
	 * @param Event $event
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Club $club, Event $event ) {
		return view( 'dashboard.events.edit', compact( 'event', 'club' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Event $event
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Event $event, Request $request ) {
		$event->update( $request );

		return back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return void
	 */
	public function destroy( $id ) {
		//
	}
}
