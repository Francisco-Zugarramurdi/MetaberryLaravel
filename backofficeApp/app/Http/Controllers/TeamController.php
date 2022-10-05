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
        $validation = $this->validateCreationRequest($request);
        if($validation !== "ok"){
            return $validation;
        }
        try {
            return $this->createTeam($request);
            return redirect('/team');
        }
        catch (QueryException $e){

            return [
                "error" => 'Cannot create Team',
                "trace" => $e -> getMessage()
            ];

        }
    }

    private function validateCreationRequest($request){
        $validator = Validator::make($request->all(),[

            'name' => 'required',
            'photo' => 'required',
            'typeTeam' => 'required',
            'sport' => 'required',
            'country' => 'required'

        ]);

        if($validator->fails())
            return $validator->errors()->toJson();
        
        if(Team::withTrashed()->where('name', $request -> post("name")) -> exists())
            return 'The team already exist';
        
        if(!Sport::withTrashed()->where('name', $request -> post("sport")) -> exists())
            return 'the sport do not exist';

        if(!Country::withTrashed()->where('name', $request -> post("country")) -> exists())
            return 'the country do not exist';
        
        return 'ok';
    }

    private function createTeam(Request $request){
        
        
        $user = Team::create([
            'name' => $request -> post("name"),
            'typeTeam' => $request -> post("typeTeam"),
            'photo' => $request -> post("photo"),
            'id_sports' => Sport::where('name', $request -> post("sport"))->id,
            'id_country' => Country::where('name', $request -> post("country"))->id
        ]);
        return redirect('/team');
    }

    public function index(){
        $teams = Team::join('sports','sports.id','teams.id_sports')
        ->join('countries', 'countries.id', 'teams.id_countries')
        ->select("teams.id as id", "teams.name as name", "teams.photo as photo","teams.tipo_teams as typeTeam", "sports.name as sportName", "countries.name as countryName")
        ->get();
        return Sport::all();
        return view('teams')->with('teams',$teams);
    }

    public function update(Request $request, $id){
        $team = Team::findOrFail($id);
        $team -> name = $request->namespace;
        $team -> photo = $request-> credit_card;
        $team -> typeTeam = $request -> typeTeam;
        $team -> sport = Sport::where('name', $request -> post("sport"))->id;
        $team -> country = Country::where('name', $request -> post("country"))->id;
        return redirect('/team');
    }

    public function destroy($id){
        try{
            Team::findOrFail($id)->delete();
            return redirect('/team');
        }
        catch(QueryException $e){
            return [
                "error" => 'Cannot delete team',
                "trace" => $e -> getMessage()
            ];
        }
    }

}
