<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Sanction;
use App\Models\SanctionPlayers;
use App\Models\SanctionExtra;
use App\Models\Player;
use App\Models\Event;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


class SanctionController extends Controller
{
    public function index(){
        $sanctions = DB::table('sanctions')
        ->join('sanctions_players','sanctions_players.id_sancion','sanctions.id')
        ->join('players','players.id','sanctions_players.id_players')
        ->join('events','events.id','sanctions.id_events')
        ->select('sanctions.id as id','sanctions_players.minute as minute', 'sanctions_players.id_players as idPlayer','players.name as namePlayer','sanctions.sancion as sancion', 'sanctions.id_events as idEvent','events.name as nameEvent')
        ->get();
        $sanctionExtra = DB::table('sanctions')
        ->join('sanctions_extra','sanctions_extra.id_sancion','sanctions.id')
        ->join('extras','extras.id','sanctions_extra.id_extra')
        ->join('events','events.id','sanctions.id_events')
        ->select('sanctions.id as id','sanctions_extra.minute as minute', 'sanctions_extra.id_extra as idPlayer','extras.name as namePlayer','sanctions.sancion as sancion', 'sanctions.id_events as idEvent','events.name as nameEvent')
        ->get();
        return view('sanctions')->with('sanctions',$sanctions)->with('events',Event::all())->with('sanctionsExtra',$sanctionExtra);
    }
    public function create(Request $request){
        $validation = $this->validateRequest($request);
        if($validation !== "ok")
            return $validation;
        try{
            return $this->createSanction($request);
        }catch(QueryException $e){
            return $e;
            return view('error')->with('errorData',$e)->with('errors', 'Cannot create sanction');

        }
    }
    private function validateRequest(Request $request){
        $validation = Validator::make($request->all(),[
            'sanction'=> 'required',
            'event'=>'required',
            'player'=>'required',
            'minute'=>'required',
            'type'=>'required',
        ]);
        if($validation->fails())
        return $validation->errors()->toJson();
        return 'ok';
    }
    private function createSanction(Request $request){
        $sanction = Sanction::create([
            'sancion'=>$request->sanction,
            'id_events'=>$request->event,
        ]);
        if($request->type == "Player"){
            SanctionPlayers::create([
                'id_sancion'=>$sanction->id,
                'id_players'=>$request->player,
                'minute'=>$request->minute
            ]);
        }
        if($request->type == "Extra"){
            SanctionExtra::create([
                'id_sancion'=>$sanction->id,
                'id_extra'=>$request->player,
                'minute'=>$request->minute
            ]);
        }
       

    }
}
