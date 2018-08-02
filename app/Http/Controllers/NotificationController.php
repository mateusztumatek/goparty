<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');

    }

    public function store(Request $request){


    }

    public function mark(Request $request){


        foreach ($request->notifications as $notification){
            $notification = Notification::findOrFail($notification);
            $notification->open = true;
            $notification->update();
        }
        return response('udalo sie');
    }

    public function markNotOpen(){

    }
}
