<?php

namespace App\Http\Controllers\User;

use App\Models\City;
use App\Models\Club;
use App\Models\MusicType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ClubsController extends Controller
{

	public function __construct() {
		$this->middleware('auth', ['except' => ['index', 'show']]);
		$this->middleware('club_permission', ['except' => ['index', 'show', 'create']]);
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubs = Club::all();
        return response($clubs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$cities = City::all();
    	$musicTypes = MusicType::all();
        return view('clubs.create', compact('cities', 'musicTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    $club = Club::findOrFail($id);
	    return response($club);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}