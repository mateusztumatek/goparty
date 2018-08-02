<?php

namespace App;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use App\Models\Club;

class Notification extends Model
{
    protected $fillable = ['message', 'user_id', 'owner_id', 'open', 'club_id', 'event_id', 'rate'];

    public function getUser(){
        return User::findOrFail($this->user_id);
    }

    public function getOwner(){
        return User::findOrFail($this->owner_id);
    }

    public function getClub(){
        return Club::findOrFail($this->club_id);
    }

    public function getEvent(){
        return Event::findOrFail($this->event_id);
    }


}
