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
        $this->validateCreationRequest();
        if($validation !== "ok"){
            return $validation;
        }
        try {
            return $this->createTeam($request);
        }
        catch (QueryException $e){

            return [
                "error" => 'Cannot create Team',
                "trace" => $e -> getMessage()
            ];

        }
    }

    private function validateCreationRequest(){
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
            return 'The team already exist'
        
        if(!Sport::withTrashed()->where('name', $request -> post("sport")) -> exists())
            return 'the sport do not exist'

        if(!Country::withTrashed()->where('name', $request -> post("country")) -> exists())
            return 'the country do not exist'
        
        return 'ok';
    }

    private function createTeam(){
        $user = Team::create([
            'name' => $request -> post("name"),
            'typeTeam' => $request -> post("typeTeam"),
            'photo' => $request -> post("photo"),
            'id_sports' => Sport::where('name', $request -> post("sport"))->id;
            'id_country' => Country::where('name', $request -> post("country"))->id;
        ]);
    }

    public function index(){
        $teams = Team::join('countries','countries.id','=','teams.id_countries')->join('sports','sports.id','=','teams.id_sports')->get();
        return $teams;
    }

    public function update(Request $request, $id){

    }

    public function destroy($id){
        try{
            Team::findOrFail($id)->delete();
            

        }
        catch(QueryException $e){
            return [
                "error" => 'Cannot delete user',
                "trace" => $e -> getMessage()
            ];
        }
    }

}
