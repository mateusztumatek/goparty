<?php

namespace App\Listeners\ClubDestroy;

use App\Events\ClubDestroy;
use App\Models\Club;
use Illuminate\Support\Facades\Auth;

class RemoveRole
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ClubDestroy  $event
     * @return void
     */
    public function handle(ClubDestroy $event)
    {
	    $clubs = Club::where( 'user_id', Auth::id() )->get();

	    if ( $clubs->count() == 0 && Auth::user()->hasRole( 'owner' ) ) {
		    Auth::user()->removeRole( 'owner' );
	    }
    }
}
