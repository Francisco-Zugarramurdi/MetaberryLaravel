<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Player;
use App\Models\PlayerTeam;
use App\Models\Team;
use \Illuminate\Database\QueryException;

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
                'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            ]
        ]);
        if($validation->fails())
            return $validation->errors()->toJson();
        if(!Team::where('name','=',$request->teamName)->exists())
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
        $players = Player::rightJoin('players_teams','players_teams.id_players','players.id');
        return view('players')->with('players',Player::all());
        
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
}
