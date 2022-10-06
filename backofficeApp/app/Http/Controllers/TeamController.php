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
        
        if(Team::where('name', $request -> post("name")) -> exists())
            return 'The team already exist';
        
        if(!Sport::where('name', $request -> post("sport")) -> exists())
            return 'the sport do not exist';

        if(!Country::zwhere('name', $request -> post("country")) -> exists())
            return 'the country do not exist';
        
        return 'ok';
    }

    private function createTeam(Request $request){
        
        //este metodo tiene que ser actualizado en el caso de que se cambie la bd a type_teams
        $user = Team::create([
            'name' => $request -> post("name"),
            'tipo_teams' => $request -> post("typeTeam"),
            'photo' => $request -> post("photo"),
            'id_sports' => Sport::where('name', $request -> post("sport"))->first()->id,
            'id_countries' => Country::where('name', $request -> post("country"))->first()->id
        ]);
        return redirect('/team');
    }

    public function index(){
        $teams = Team::join('sports','sports.id','teams.id_sports')
        ->join('countries', 'countries.id', 'teams.id_countries')
        ->select("teams.id as id", "teams.name as name", "teams.photo as photo","teams.tipo_teams as typeTeam", "sports.name as sportName", "countries.name as countryName")
        ->get();
        return view('teams')->with('teams',$teams);
    }

    public function update(Request $request, $id){
        $team = Team::findOrFail($id);
        $team -> name = $request->name;
        $team -> photo = $request-> photo;
        $team -> tipo_teams = $request -> typeTeam;
        $team -> id_sports = Sport::where('name', $request->sportName)->first()->id;
        $team -> id_countries = Country::where('name', $request -> countryName)->first()->id;
        $team -> save();
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
