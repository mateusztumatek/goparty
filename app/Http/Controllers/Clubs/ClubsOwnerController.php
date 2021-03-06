<?php

namespace App\Http\Controllers\Clubs;

use App\Events\ClubCreated;
use App\Events\ClubDestroy;
use App\Models\Club;
use App\models\ClubImage;
use App\Models\Event;
use App\Models\MusicType;
use App\Models\Rules;
use App\Models\ClubRules;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Routing\Tests\Fixtures\CustomCompiledRoute;
use Illuminate\Support\Facades\DB;


class ClubsOwnerController extends Controller {

	public function __construct() {
		/* Check if user has owner role*/
		$this->middleware( 'auth', [ 'except' => [ 'index', 'show' ] ] );

		/* Check if user has owner role*/
		$this->middleware( 'role:owner', [ 'except' => [ 'create', 'store' ] ] );

		/* Check if user has permission (club belongs to user etc. in middleware) */
		$this->middleware( 'club_permission', [ 'except' => [ 'index', 'create', 'store' ] ] );
	}


	public function index() {
		$clubs = Club::where( 'user_id', Auth::id() )->paginate(5);


		return view( 'dashboard.clubs.index', compact( 'clubs' ) );
	}

	public function create() {
		$musicTypes = MusicType::all();
        $rules = Rules::all();
		return view( 'dashboard.clubs.create', compact( 'musicTypes', 'rules' ) );
	}


	public function store( Request $request ) {

		$addressErrorMessage = 'Wprowadzony przez ciebie adres jest niepoprawny. Wprowadź pełny adres (nazwa ulicy/numer
                    lokalu/miasto/kraj)';

		if($request->file('club_img')){
			$imageName = time().'.'.$request->file('club_img')->getClientOriginalExtension();
			$request->file('club_img')->move(public_path('uploads/clubs'), $imageName);
		} else {
			$imageName = null;
		}

		$this->validate( $request, [
			'latitude'      => 'required',
			'longitude'     => 'required',
			'street_number' => 'required',
		], [
			'latitude.required'      => $addressErrorMessage,
			'longitude.required'     => $addressErrorMessage,
			'street_number.required' => 'Prosimy o podanie dokładniejszych danych adresowych (number lokalu)',
		] );

		$club = Club::create( [
			'user_id'                 => Auth::id(),
			'official_name'           => $request->official_name,
			'role'                    => $request->role,
			'email'                   => $request->email,
			'country'                 => $request->country,
			'locality'                => $request->locality,
			'voivodeship'             => $request->voivodeship,
			'route'                   => $request->route,
			'street_number'           => $request->street_number,
			'postal_code'             => '00000',
			'latitude'                => $request->latitude,
			'longitude'               => $request->longitude,
			'additional_address_info' => $request->additional_address_info,
			'phone'                   => $request->phone,
			'website_url'             => $request->website_url,
			'facebook_url'            => $request->facebook_url,
			'club_img'                => $imageName
		] );
		if(!empty($request->rules)){
            foreach($request->rules as $rule){
                ClubRules::create([
                    'club_id' => $club->id,
                    'rule_id' => $rule,
                ]);
            }
        }

		foreach ($request->music_types as $music_type){
		    DB::table('club_music_type')->insert([
		       'club_id' => $club->id,
               'music_type_id' => $music_type,
            ]);
        }


		event(new ClubCreated($club));

		Session::flash( 'message', 'Klub ' . $request->official_name . ' dodany pomyślnie, teraz możesz uzupełnić dodatkowe informacje, lub dodać wydarzenie.' );

		return redirect( 'dashboard/clubs' );
	}


	public function show( $id ) {
		$club = Club::findOrFail( $id );

		$rules = ClubRules::where('club_id', $id)->get();
		$events = Event::where('club_id', $id)->get();
		return view( 'dashboard.clubs.single', compact( 'club', 'rules', 'events' ) );
	}


	public function edit( Club $club ) {
		$musicTypes = MusicType::all();
		$images = ClubImage::where('club_id', $club->id)->get();
        $rules = Rules::all();

        $club->setMusicTypes();

		return view( 'dashboard.clubs.edit', compact( 'club', 'musicTypes', 'images', 'rules' ) );
	}

	public function update( Request $request, Club $club ) {

		$club->update( [
			'user_id'                 => Auth::id(),
			'official_name'           => $request->official_name,
			'role'                    => $request->role,
			'email'                   => $request->email,
			'country'                 => $request->country,
			'locality'                => $request->locality,
			'voivodeship'             => $request->voivodeship,
			'route'                   => $request->route,
			'street_number'           => $request->street_number,
			'postal_code'             => '00000',
			'latitude'                => $request->latitude,
			'longitude'               => $request->longitude,
			'additional_address_info' => $request->additional_address_info,
			'phone'                   => $request->phone,
			'website_url'             => $request->website_url,
			'facebook_url'            => $request->facebook_url,
		] );
		if(!empty(ClubRules::where('club_id', $club->id))){
		    $club_rules = ClubRules::where('club_id', $club->id)->delete();

        }
        if(!empty($request->rules)){
            foreach ($request->rules as $rule){
                ClubRules::create([
                    'club_id' => $club->id,
                    'rule_id' => $rule,
                ]);
            }
        }
        DB::table('club_music_type')->where('club_id', $club->id)->delete();
        if(!empty($request->music_types)){
            foreach ($request->music_types as $music_type){

                DB::table('club_music_type')->insert([
                    'club_id' => $club->id,
                    'music_type_id' => $music_type,
                ]);
            }

        }

		return back()->with(['message' => 'klub został edytowany poprawnie']);
	}



	public function destroy( Club $club ) {

		try {
			$club->delete();
		} catch ( \Exception $e ) {
		}

		event(new ClubDestroy());

		return redirect()->route( 'user-dashboard.index' );
	}

	public function clubEvents( Club $club ) {
		return view( 'dashboard.clubs.events', compact( 'club' ) );
	}

}
