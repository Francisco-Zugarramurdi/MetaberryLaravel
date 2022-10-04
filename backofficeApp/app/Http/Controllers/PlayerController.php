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
        return 'ok';
        
    }
    private function createPlayer(Request $request){
        Player::create([
            'name'=> $request->name,
            'surname'=> $request->surname,
            'photo'=> $request->name
        ]);
        if($request->teamName != null)
            $this->joinTeam($request->teamName,$request->StartDate);

        return redirect('/player');

    }
    private function joinTeam($name, $date){
        $team = Team::where('name','=',$name);
        TeamPlayer::create();
    }
    public function index(){
        return view('players')->with('players',Player::all());
        
    }
}
