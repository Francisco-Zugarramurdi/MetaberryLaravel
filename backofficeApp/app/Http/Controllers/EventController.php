<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\EventTeam;
use App\Models\LeagueEvent;
use App\Models\Country;
use App\Models\Sport;
use App\Models\League;
use App\Models\Extra;
use App\Models\Team;
use App\Models\Player;
use App\Models\Result;
use App\Models\ResultPoint;

use \Illuminate\Database\QueryException;

class EventController extends Controller
{  

    public function index(){
        
        return view('events')
        ->with('countries',Country::all())
        ->with('sports',Sport::all())
        ->with('leagues',League::all())
        ->with('players',Player::all())
        ->with('teams',Team::all());
    }

    public function createEventSet(Request $request){

        $validation = $this->validateCreationRequest($request);
        if($validation !== "ok"){
            return $validation;
        }

        try{
            $event = $this->createEvent($request);
            if($request->league != null)
                $this->addLeague($request,$event->id);
            if($request->resultReady !=null)
                $this->addSet($request,$event->id);

            return redirect('/event');
        }
        catch(QueryException $e){
            return 'Cannot create event';
        }
           
    }
    private function addSet(Request $request, $eventID){
        $result = DB::table('results')->insertGetId([
            'type_results'=>"set",
            'results'=>" ",
            'id_events'=>$eventID
        ]);
        $setsLocal = $request->input('setsLocal');
        $setsVisitant = $request->input('setsVisitant');
        $setNumber = 0;
        foreach($setsLocal as $set){
          $setNumber++;  
          DB::table('points_sets')->insert([
            'number_set' => $setNumber,
            'points_set' => $set,
            'id_teams' => $request->localTeam,
            'id_results'=>$result,
          ]);

        }
        foreach($setsVisitant as $set){
            $setNumber++;  
            DB::table('points_sets')->insert([
              'number_set' => $setNumber,
              'points_set' => $set,
              'id_teams' => $request->visitantTeam,
              'id_results'=>$result,
            ]);
  
        }

    }

    public function createEventPoint(Request $request){
        $validation = $this->validateCreationRequest($request);
        if($validation !== "ok"){
            return $validation;
        }

        try{
            $event = $this->createEvent($request);
            if($request->league != null)
                $this->addLeague($request,$event->id);
            if($request->resultReady !=null)
               return $this->addPoint($request,$event->id);
            return redirect('/event');
        }
        catch(QueryException $e){
            return $e;
        }

    }
    private function addPoint(Request $request, $eventID){
        $result = DB::table('results')->insertGetId([
            'type_results'=>"score",
            'results'=>" ",
            'id_events'=>$eventID
        ]);
        foreach($request-> pointsLocal as $point){
            DB::table('results_points')->insert([
                'id_players' => $point['player'],
                'point' => $point['points'],
                'id_teams' => $request->localTeam,
                'id_results'=>$result,
            ]);

        }
        foreach($request->pointsVisitor as $point){
            DB::table('results_points')->insert([
                'id_players' => $point['player'],
                'point' => $point['points'],
                'id_teams' => $request->visitorTeam,
                'id_results'=>$result,
            ]);
        }
    }

    private function validateCreationRequest(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'details' => 'required',
            'date' => 'required',
            'relevance' => 'required',
            'country' => 'required',
            'sport' => 'required'
        ]);
        if ($validator->fails())
            return $validator->errors()->toJson();
    
        return 'ok';
    }
    
    private function createEvent(Request $request){
    
        return Event::create([
            'name' => $request->name,
            'details' => $request->details,
            'id_sports' => $request->sport,
            'id_countries' => $request->country,
            'date' => $request->date,
            'relevance' => $request->relevance
        ]);
    
    }
    
    private function addLeague(Request $request, $eventID){
        DB::table('leagues_events')->insert([
            'id_events'=>$eventID,
            'id_leagues'=>$request->league,
        ]);
    }

}



