<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Sport;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function create(Request $request){

        $validation = $this->validateRequest($request);

        if($validation !== "ok"){
            return $validation;
        }
        if(Team::where('name', $request -> post("name")) -> exists())
            return view('error')->with('errors', 'Team already exists');

        try {
            return $this->createTeam($request);
        }
        catch (QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot create team');

        }
    }

    private function createTeam(Request $request){

        Team::create([
            'name' => $request -> post("name"),
            'type_teams' => $request -> post("typeTeam"),
            'photo' => $request -> post("photo"),
            'id_sports' => Sport::where('name', $request -> post("sportName"))->first()->id,
            'id_countries' => Country::where('name', $request -> post("countryName"))->first()->id
        ]);

        return redirect('/team');
    }

    public function index(){
        $teams = Team::join('sports','sports.id','teams.id_sports')
        ->join('countries', 'countries.id', 'teams.id_countries')
        ->select("teams.id as id", "teams.name as name", "teams.photo as photo","teams.type_teams as typeTeam", "sports.name as sportName", "countries.name as countryName")
        ->get();

        $country = Country::all();
        $sport = Sport::all();

        return view('teams')->with('teams',$teams)->with('countries', $country)->with('sports', $sport);
    }

    public function getTeams(){
        
        return Team::all();
    }

    public function update(Request $request, $id){

        $validation = $this->validateRequest($request);

        if(Team::where('name', $request -> post("name"))->exists())
            return view('error')->with('errors', 'Team already exists');

        if($validation !== "ok")
            return $validation;
        try {
            $this->updateTeam($request, $id);
            return redirect('/team');
        }
        catch (QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot update team');
        }
        
    }

    private function validateRequest($request){
        $validator = Validator::make($request->all(),[

            'name' => 'required',
            'photo'=> [
                'required',
                'regex:/(?i)^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            ],
            'typeTeam' => 'required',
            'sportName' => 'required',
            'countryName' => 'required'

        ]);

        if($validator->fails())
            return $validator->errors()->toJson();
        
        return 'ok';
    }

    private function updateTeam(Request $request, $id){
        $team = Team::findOrFail($id);
        $team -> name = $request->name;
        $team -> photo = $request-> photo;
        $team -> type_teams = $request -> typeTeam;
        $team -> id_sports = Sport::where('name', $request->sportName)->first()->id;
        $team -> id_countries = Country::where('name', $request -> countryName)->first()->id;
        $team -> save();
        return redirect('/team');
    }


    public function destroy($id){

        $validation = $this->validateDestroy($id);

        if($validation !== "ok"){
            return view('error')->with('errors', $validation);
        }
        try{
            Team::findOrFail($id)->delete();
            return redirect('/team');
        }
        catch(QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot delete team');
        }
    }

    private function validateDestroy($id){

        if(DB::table('events_teams')->where('id_teams',$id)->exists()){
            return 'Cannot destroy team because it is related to an event';
        }
        return 'ok';

    }

    private function delete($id){



    }
}
