<?php

namespace App\Http\Controllers\Events;

use App\Models\Event;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;

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
            ->paginate(10);

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
        /*
         * @TODO
         * Dorobic tutaj ze jak nie podal zadnej daty to jest startowa dzisiejsza a koncowa dzisiejsza + 7 dni 
         */

        $city = $request->get('city');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $city = strstr($city, ',', true);

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


        $events = $events->paginate(10);
        $events->withPath('search-events?city=' . $city . '&start_date=' . $startDate . '&end_date=' . $endDate);

//	    return response()->json($events);
        return view('site.events.search-result', compact('events'));
    }

}
