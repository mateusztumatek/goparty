<?php

namespace App\Listeners;

use App\Notification;
use App\Events\NotificationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class MakeNotification
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
     * @param  Notification  $event
     * @return void
     */
    public function handle(NotificationEvent $event)
    {

      if($event->message == 'rate'){
          Notification::create([
             'user_id' => $event->user,
             'owner_id' => $event->owner,
              'club_id' => intval($event->club),
              'message' => $event->message,
              'rate' => $event->rate,
          ]);
      }

        if($event->message == 'event-attendance'){
            Notification::create([
                'user_id' => $event->user,
                'owner_id' => $event->owner,
                'message' => $event->message,
                'event_id' => $event->event,
            ]);
        }

    }
}
