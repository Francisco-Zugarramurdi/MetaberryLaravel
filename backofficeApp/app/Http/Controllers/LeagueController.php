<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\League;
use App\Models\Country;
use App\Models\LeagueCountry;
use \Illuminate\Database\QueryException;

class LeagueController extends Controller
{
    public function create(Request $request){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok")
            return $validation;

        try{

            return $this->createLeague($request);

        }catch(QueryException $e){

            return [
                "error" => 'Cannot create league',
                "trace" => $e -> getMessage()
            ];

        }
    }

    private function validateCreationRequest(Request $request){

        $validation = Validator::make($request->all(),[
            'name'=> 'required',
            'details'=> 'required',
            'photo'=> [
                'required',
                'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            ]
        ]);

        if($validation->fails())
            return $validation->errors()->toJson();

        if(!Country::where('name','=',$request->countryName)->exists())
            return "Error, that country does not exist";

        return 'ok';
    }

    public function createLeague(Request $request){

        $league = League::create([
            'name'=> $request->name,
            'details'=> $request->details,
            'photo'=> $request->photo
        ]);

        $this->joinTable($request, $league->id);

        return redirect('/league');

    }

    private function joinTable(Request $request, $id){

        $country = Country::where('name',$request->countryName)->first();
        LeagueCountry::create([
            'id_countries' => $country->id,
            'id_leagues' => $id
        ]);

    }

    public function index(Request $request){
    
        $league = League::join('leagues_countries', 'leagues_countries.id_leagues', 'leagues.id');
        $country = Country::all();

        return view('users')->with('leagues', $league)->with('countries', $country);

    }
}
