<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\Club;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request){

        Rating::where('user_id', $request->user_id)->where('club_id', $request->club_id)->delete();

        $rate = Rating::create([
           'user_id' => $request->user_id,
           'club_id' => $request->club_id,
           'rate' => $request->rate
        ]);

       event( new NotificationEvent((Club::findOrFail($request->club_id))->user_id, Auth::id(), $request->club_id, null, 'rate', $request->rate));

        return response()->json($rate);


    }

    public function update(Request $request){
        $rate = Rating::findOrFail($request->rate_id);
        $rate->rate = $request->rate;
        $rate->update();

        return response()->json($rate);
    }

    public function delete(Request $request){
        $rate = Rating::where('club_id', $request->club_id)->where('user_id', $request->user_id)->delete();

        return response()->json(['message'=>'twoja ocena zostala usunieta pomyslnie']);
    }
}
