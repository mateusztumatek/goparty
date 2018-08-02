<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    public $owner;
    public $message;
    public $club;
    public $event;
    public $rate;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $owner, $club, $event, $message, $rate)
    {
        $this->user = $user;
        $this->owner = $owner;
        $this->message = $message;
        $this->club = $club;
        $this->event = $event;
        $this->rate = $rate;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
