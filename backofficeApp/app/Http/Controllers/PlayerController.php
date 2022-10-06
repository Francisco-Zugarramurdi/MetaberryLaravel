<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Player;
use App\Models\PlayerTeam;
use App\Models\Team;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function create(Request $request){
        $validation = $this->validateCreationRequest($request);
        if($validation !== "ok")
            return $validation;
        try{
            return $this->createPlayer($request);
        }catch(QueryException $e){
            return [
                "error" => 'Cannot create player',
                "trace" => $e -> getMessage()
            ];
        }
    }
    private function validateCreationRequest(Request $request){
        $validation = Validator::make($request->all(),[
            'name'=> 'required',
            'surname'=> 'required',
            'photo'=> [
                'required',
                'regex:/(?i)^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            ]
        ]);
        if($validation->fails())
            return $validation->errors()->toJson();
        if(!Team::where('name','=',$request->teamName)->exists() && $request->teamName != null)
            return "Error, team does not exist";
        return 'ok';

    }
    private function createPlayer(Request $request){
        $player = Player::create([
            'name'=> $request->name,
            'surname'=> $request->surname,
            'photo'=> $request->photo
        ]);
        if($request->teamName != null)
            $this->joinTeam($request,$player->id);

        return redirect('/player');

    }
    private function joinTeam(Request $request,$id){
        $team = Team::where('name',$request->teamName)->first();
        PlayerTeam::create([
            'id_teams' => $team->id,
            'id_players' => $id,
            'contract_start' => $request->contractStart
        ]);
    }
    public function index(){
        $players = Player::leftJoin('players_teams','players_teams.id_players','players.id')
        ->leftJoin('teams','players_teams.id_teams','teams.id')
        ->select('players.id as id','players.name as name','players.surname as surname','players.photo as photo','teams.name as teamName','players_teams.contract_start as contractStart')
        ->get();
        return view('players')->with('players',$players);
        
    }
    public function destroy($id){
        try{
            Player::findOrFail($id)->delete();
            return redirect('/player');
        }
        catch(QueryException $e){
            return [
                "error" => 'Cannot delete player',
                "trace" => $e -> getMessage()
            ];
        }
        
    }
    public function update(Request $request, $id){

        $validation = $this->validateCreationRequest($request);
        if($validation !== "ok")
            return $validation;
        try{
            $this->updatePlayer($request,$id);    
            $this->updateTeam($request,$id);
           
            return redirect('/player');
            
        }
        catch (QueryException $e){

            return [
                "error" => 'Cannot update player',
                "trace" => $e -> getMessage()
            ];
            
        }

    }
    private function updatePlayer($request,$id){
        $player = Player::findOrFail($id);
        $player->name = $request->name;
        $player->surname = $request->surname;
        $player->photo = $request->photo;
        $player->save();
    }
    private function updateTeam($request,$id){
        $team = Team::where('name',$request->teamName)->first();
        $playerTeam = DB::table('players_teams')
        ->where('id_teams',$team->id)
        ->where('id_players',$id)
        ->update(['contract_start' => $request->contractStart]);
    }
    public function addTeam(Request $request){
        $team = Team::where('name',$request->teamName)->first();
        if($team->exists()){
             DB::table('players_teams')->insert([
                'id_teams'=>$team->id,
                'id_players'=>$request->playerId,
                'contract_start'=>$request->contractStart
            ]);
        }
        return redirect('/player');

    }
}
