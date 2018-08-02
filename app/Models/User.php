<?php

namespace App;

use App\Models\MusicType;
use Backpack\CRUD\CrudTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;

class User extends Authenticatable
{
    use Notifiable;
    use CrudTrait; 
    use HasRoles; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'city_id', 'password','image_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

     /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /* Admin panel users methods */

    public function sendEmailToUser($crud){
    	return  '<a href=" ' . url('/admin/user/' .$crud->id . '/send-email' ) . ' " class="btn btn-xs btn-default"><i class="fa fa-envelope-o"></i> Send email</a>';
    }

	/* End of admin panel users methods */



    /* Relationships */

	public function favoriteMusic()
	{
		return $this->belongsToMany('App\Models\MusicType','user_music_type');
	}

	public function voivodeship()
	{
		return $this->hasOne('App\Models\Voivodeship','id','voivodeship_id');
	}

	public function city()
	{
		return $this->hasOne('App\Models\City','id','city_id');
	}

	/* End of Relationships */

	public function club_percent($club){
        /*
        Do skończenia, funkcja ma zwracac wartosc od 0 do 100
        jak bardzo klub może się podobać użytkownikowi.
        Na podstawie upodobań muzycznych klienta, a muzyce którą proponuje klub.
        */

	    return rand(0, 100);
    }

    public function getUserImage(){
	    if(($image = $this->image_path) == null){
	        return asset('img/avatar.png');
        } else   return asset('public/users/'.$this->id.'/'.$this->image_path);


    }
    public function getMusicTypes(){
	    $user_music_types = [];
	    if(($all = DB::table('user_music_type')->where('user_id', $this->id)->get()) != null);
	    foreach ($all as $music_type){
	        $music_types = MusicType::findOrFail($music_type->music_type_id);
	        array_push($user_music_types, $music_types);
        }

        return $user_music_types;
    }

    public function getUserSettings(){
	    $settings = DB::table('user_settings')->where('user_id', $this->id)->first();
	    return $settings;

    }


    /* Do zrobienia
    filtrowanie klubow przez preferencje użytkownika.
    */
    public function filtrClubByUserSettings($clubs){

    }

    /* Do zrobienia
       filtrowanie wydarzeń przez preferencje użytkownika.
       */
    public function filtrEventsByUserSettings($events){

    }

    public function getNotifications(){
        $notifications = Notification::where('user_id', $this->id)->OrderBy('created_at', 'DESC')->get();

        return $notifications;
    }
}
