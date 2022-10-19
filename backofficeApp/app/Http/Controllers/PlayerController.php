<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Player;
use App\Models\PlayerTeam;
use App\Models\Team;
use App\Models\Country;
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
            return view('error')->with('errorData',$e)->with('errors', 'Cannot create player');

        }
    }
    private function validateCreationRequest(Request $request){
        $validation = Validator::make($request->all(),[
            'name'=> 'required',
            'surname'=> 'required',
            'photo'=> [
                'regex:/(?i)^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                'required'
            ]
        ]);
        if($validation->fails())
            return $validation->errors()->toJson();
        if(!Team::where('name','=',$request->teamName)->exists() && $request->teamName != null)
            return view('error')->with('errorData',$e)->with('errors', 'Team does not exist');
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
            'contract_end' =>$request->contractEnd,
            'contract_start' => $request->contractStart,
            'status' => $request->status

        ]);
    }
    public function index(){
        $players = Player::leftJoin('players_teams','players_teams.id_players','players.id')
        ->leftJoin('teams','players_teams.id_teams','teams.id')
        ->select('players.id as id','players.name as name','players.surname as surname','players.photo as photo','teams.name as teamName','players_teams.contract_start as contractStart','players_teams.contract_end as contractEnd','players_teams.status as status')
        ->get();
        return view('players')->with('players',$players)->with('teams',Team::all());
        
    }
    public function destroy($id){
        try{
            Player::findOrFail($id)->delete();
            return redirect('/player');
        }
        catch(QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot destroy player');
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
            return view('error')->with('errorData',$e)->with('errors','Cannot update player');
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
        ->update([
            'contract_start' => $request->contractStart,
            'contract_end' => $request->contractEnd,
            'status' => $request->status ]);
    }
    public function addTeam(Request $request){
        $team = Team::where('name',$request->teamName)->first();
        if($team->exists()){
             DB::table('players_teams')->insert([
                'id_teams'=>$team->id,
                'id_players'=>$request->playerId,
                'contract_start'=>$request->contractStart,
                'contract_end' =>$request->contractEnd,
                'status' =>$request->status
            ]);
        }
        return redirect('/player');
    }

    public function indexPlayersById(Request $request){
        return Player::leftJoin('players_teams','players_teams.id_players','players.id')
        ->leftJoin('teams','players_teams.id_teams','teams.id')
        ->select('players.id as id','players.name as name','players.surname as surname','players.photo as photo','teams.name as teamName','teams.id as teamId','players_teams.contract_start as contractStart','players_teams.contract_end as contractEnd','players_teams.status as status')
        ->get()
        ->where('teamId', $request->teamId);
    }
    public function indexPlayersByEvent(Request $request){
        $players = DB::table('events')
        ->join('events_teams','events_teams.id_events','events.id')
        ->join('players_teams','players_teams.id_players','events_teams.id_teams')
        ->join('players','players.id','players_teams.id_players')
        ->select('players.id as id','players.name as name','events_teams.id_events as eventId')
        ->get()
        ->where('eventId',$request->id);
        return $players;
    }
}
