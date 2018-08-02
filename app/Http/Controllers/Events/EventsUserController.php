<?php

namespace App\Http\Controllers\Events;

use App\EventAttendance;
use App\Events\NotificationEvent;
use App\Models\Club;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\MusicType;
use http\Env\Response;

use Illuminate\Support\Facades\Auth;

class EventsUserController extends Controller
{

    public function index()
    {

    }

    public function allEvents()
    {
        $events = Event::with('club')
            ->where('start_date', '>=', date('Y-m-d H:i:s'))
            ->orderBy('start_date')
            ->paginate(12);

        return view('site.events.index', compact('events'));
    }

    public function clubEvents()
    {
        echo 'single.club.events';
    }

    /**
     * @param Event $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function singleEvent(Event $event)
    {
        return view('site.events.single', compact('event'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchEvents(Request $request)
    {

	    $request->validate([
		    'start_date' => 'required',
		    'end_date' => 'required',
	    ]);

        $city = $request->get('city');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

	    if (strpos($city, ',')) {
		    $city = strstr($city, ',', true);
	    }



        $events = Event::with('club');

//        var_dump($city);

        if ($startDate && $endDate) {

            $events = $events->where([
                ['start_date', '>=', $startDate],
                ['start_date', '<=', $endDate],
            ]);

            if ($city) {
                $events = $events
                    ->whereHas('club', function ($query) use ($city) {
                        $query->where('locality', 'like', $city);
                    });
            }

        } else if ($startDate && !$endDate) {
            $events = $events->where('start_date', '>=', $startDate);
            if ($city) {
                $events = $events
                    ->whereHas('club', function ($query) use ($city) {
                        $query->where('locality', 'like', $city);
                    });
            }
        } else if ($endDate && !$startDate) {
            $events = $events->where('start_date', '<=', $endDate);
            if ($city) {
                $events = $events
                    ->whereHas('club', function ($query) use ($city) {
                        $query->where('locality', 'like', $city);
                    });
            }
        } else if (!$endDate && !$startDate) {
            $events = $events
                ->whereHas('club', function ($query) use ($city) {
                    $query->where('locality', 'like', $city);
                });
        } else {

        }

        $events = $events->orderBy('start_date')->paginate(10);
        $events->withPath('search-events?city=' . $city . '&start_date=' . $startDate . '&end_date=' . $endDate);

        $musicTypes = MusicType::all();

//	    return response()->json($events);
        return view('site.events.search-result', compact('events', 'musicTypes'));
    }

	public function takePart( Request $request ) {

    	if(!Auth::check()){
    		return view('auth.login');
	    } else {
            $eventAttendance = EventAttendance::create([
                'user_id' => Auth::id(),
                'event_id' => $request->event_id,
                'status' => 1
            ]);

            $events = EventAttendance::where('user_id', Auth::id())->get();
            $event_user = (Event::findOrFail($request->event_id))->user_id;
            event(new NotificationEvent($event_user, Auth::id(), null, $request->event_id, 'event-attendance', null));
            return view('dashboard.events.attendance', compact('events'));

        }



	}

	public function cancelEvent( Request $request ) {

		if(!Auth::check()){
			return view('auth.login');
		} else {
//			$eventAttendance = EventAttendance::where( [
//				'user_id' => Auth::id(),
//				'event_id' => $request->event_id,
//				'status' => 1
//			] );

			$event = EventAttendance::where([
				['user_id', '=', Auth::id()],
				['event_id', '=', $request->event_id]
			])->delete();

//			var_dump($event);

			$events = EventAttendance::where('user_id', Auth::id())->get();
			return view('dashboard.events.attendance', compact('events'));
		}


	}

	public function eventsAttendanceIndex(){

    	$user = Auth::id();

		$events = EventAttendance::where('user_id', Auth::id())->get();
		return view('dashboard.events.attendance', compact('events'));
	}

    public function attendEvent(Request $request){
        if(DB::table('attendances')->where('user_id', $request->user_id)->where('event_id', $request->event_id)->exists()) {
            return response()->json(['message' => 'dodales juz swoje uczestnictwo']);
        } else{


        DB::table('attendances')->insert([
            'user_id' => $request->user_id,
            'event_id'=> $request->event_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $event = Event::findOrFail($request->event_id);

        }
        return response()->json(['message'=>'wezmiesz udzial w tym wydarzeniu', 'event' => 'attend']);

    }

    public function notAttendEvent(Request $request){
	     DB::table('attendances')->where('user_id', $request->user_id)->where('event_id', $request->event_id)->delete();

	     return response()->json(['message' => 'nie wezmiesz udzialu w tym wydarzeniu', 'event' => 'notattend']);
    }
}
