<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\League;
use App\Models\Country;
use App\Models\LeagueCountry;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class LeagueController extends Controller
{
    public function create(Request $request){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok")
            return $validation;

        try{

            return $this->createLeague($request);

        }catch(QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot create league');

        }
    }

    private function validateCreationRequest(Request $request){

        $validation = Validator::make($request->all(),[
            'name'=> 'required',
            'details'=> 'required',
            'photo'=> [
                'required',
                'regex:/(?i)^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            ]
        ]);

        if($validation->fails())
            return $validation->errors()->toJson();

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

        $country = Country::where('id',$request->countryName)->first();
        LeagueCountry::create([
            'id_countries' => $country->id,
            'id_leagues' => $id
        ]);

    }

    public function index(Request $request){
    
        $league = League::join('leagues_countries', 'leagues_countries.id_leagues', 'leagues.id')
        ->join('countries','countries.id','leagues_countries.id_countries')
        ->select('leagues.id as id','leagues.name as name','leagues.details as details','leagues.photo as photo','countries.name as countryName', 'countries.id as countryId')
        ->get();

        $country = Country::all();

        return view('league')->with('leagues', $league)->with('countries', $country);
    }

    public function update(Request $request, $id){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok")
            return $validation;
        
        try{
                
            $this->updateLeagueData($request, $id);
            $this->updateLeagueCountryData($request, $id);

            return redirect('/league');
            
        }
        catch (QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot update league');
            
        }

    }

    private function updateLeagueData(Request $request, $id){

        $league= League::findOrFail($id);
        $league -> name = $request -> name;
        $league -> details = $request-> details;
        $league -> photo = $request -> photo;
        $league-> save();

    }

    private function updateLeagueCountryData(Request $request, $id){

        $country = DB::table('leagues_countries')
        ->where('id_leagues', $id)
        ->update(['id_countries' => $request->countryName]);

    }

    public function destroy($id){
        if(DB::table('leagues_events')->where('id_leagues',$id)->exists())
            return 'Cannot destroy league because there is related to an event';
        try{
            League::findOrFail($id)->delete();
            return redirect('/league');
        }
        catch(QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot destroy league');
        }

    }
}
