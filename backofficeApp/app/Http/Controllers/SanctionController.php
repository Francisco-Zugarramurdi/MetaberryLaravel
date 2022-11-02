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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index(){
        $sanctions = DB::table('sanctions')
        ->join('sanctions_players','sanctions_players.id_sancion','sanctions.id')
        ->join('players','players.id','sanctions_players.id_players')
        ->join('events','events.id','sanctions.id_events')
        ->where('sanctions.deleted_at',null)
        ->select('sanctions.id as id','sanctions_players.minute as minute', 'sanctions_players.id_players as idPlayer','players.name as namePlayer','players.surname as surnamePlayer','sanctions.sancion as sancion', 'sanctions.id_events as idEvent','events.name as nameEvent')
        ->orderBy('namePlayer')
        ->paginate(10);
        $sanctionExtra = DB::table('sanctions')
        ->join('sanctions_extra','sanctions_extra.id_sancion','sanctions.id')
        ->join('extras','extras.id','sanctions_extra.id_extra')
        ->join('events','events.id','sanctions.id_events')
        ->where('sanctions.deleted_at',null)
        ->select('sanctions.id as id','sanctions_extra.minute as minute', 'sanctions_extra.id_extra as idPlayer','extras.name as namePlayer','extras.surname as surnamePlayer','sanctions.sancion as sancion', 'sanctions.id_events as idEvent','events.name as nameEvent')
        ->orderBy('namePlayer')
        ->paginate(10);
        return view('sanctions')->with('sanctions',$sanctions)->with('events',Event::all())->with('sanctionsExtra',$sanctionExtra);
    }
    public function Create(Request $request){
        $validation = $this->validateRequest($request);
        if($validation !== "ok")
            return $validation;
        try{
            $this->createSanction($request);
            return redirect('/sanction');
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
    public function Update(Request $request,$id){
        $validation = $this->validateRequest($request);
        if($validation !== "ok")
            return $validation;
        try{
            $this->updateSanction($request,$id);
            return redirect('/sanction');
        }catch(QueryException $e){
            return $e;
            return view('error')->with('errorData',$e)->with('errors', 'Cannot create sanction');

        }
    }
    private function updateSanction(Request $request,$id){
        $sanction = Sanction::findOrFail($id);
        $sanction->sancion = $request->sanction;
        $sanction->save();
        if($request->type == "Player"){
            SanctionPlayers::where('id_players',$request->player)->update(['minute'=>$request->minute]);
        }
        if($request->type == "Extra"){
           SanctionExtra::where('id_extra',$request->player)->update(['minute'=> $request->minute]);
        }

    }
    public function Destroy(Request $request,$id){
        $sanction = Sanction::findOrfail($id)->delete();
        if($request->type == "Player"){
            SanctionPlayers::where('id_sancion',$id)->delete();
        }
        if($request->type == "Extra"){
           SanctionExtra::where('id_sancion',$id)->delete();
        }
        return redirect("/sanction");
    }
}
