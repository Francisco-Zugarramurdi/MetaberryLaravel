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
use App\Models\Referee;
use App\Models\RefereeEvent;
use App\Models\ResultDownward;
use App\Models\ResultUpward;
use App\Models\ResultPoint;
use App\Models\PointesSet;

use \Illuminate\Database\QueryException;
use Carbon\Carbon;

class EventController extends Controller
{  
    
    public function index(){
        
        return view('events')
        ->with('countries',Country::all())
        ->with('sports',Sport::all())
        ->with('leagues',League::all())
        ->with('players',Player::all())
        ->with('referees', Referee::all())
        ->with('teams',Team::all());
    }

    public function indexList(){
        
        $event = Event::leftJoin('leagues_events','leagues_events.id_events','events.id')
        ->leftJoin('leagues','leagues.id','leagues_events.id_leagues')
        ->join('sports','events.id_sports','sports.id')
        ->join('countries','countries.id','events.id_countries')
        ->select('events.date as date','countries.name as countryName','events.name as name','events.id as id','events.details as details','events.relevance as relevance','leagues.id as idLeague','leagues.name as leagueName','sports.name as sportName')
        ->get();

        return view('eventlist')
        ->with('events',$event)
        ->with('countries',Country::all())
        ->with('sports',Sport::all())
        ->with('leagues',League::all())
        ->with('players',Player::all())
        ->with('teams',Team::all());
    }

    public function eventEdit($id){
        

        $event = Event::leftJoin('leagues_events','leagues_events.id_events','events.id')
        ->leftJoin('leagues','leagues.id','leagues_events.id_leagues')
        ->join('sports','events.id_sports','sports.id')
        ->join('countries','countries.id','events.id_countries')
        ->join('referee_events','referee_events.id_events','events.id')
        ->join('referee','referee.id','referee_events.id_referee')
        ->join('results', 'results.id_events', 'events.id')
        ->where('events.id', $id) 
        ->select('referee.id as refereeId',
        'events.date as date', 'events.name as name','events.id as id','events.details as details','events.relevance as relevance',
        'leagues.id as idLeague','leagues.name as leagueName',
        'sports.name as sportName',
        'results.type_results as typeResult', 'results.id as resultId',
        'countries.name as countryName')
        ->get()
        ->first();

        $eventTeams = DB::table('events_teams')
        ->join('teams', 'teams.id', 'events_teams.id_teams')
        ->where('events_teams.id_events', $event->id)
        ->select('teams.id as teamId', 'teams.name as teamName', 
        'events_teams.id_events as eventId')
        ->get();

        $players = Player::join('players_teams', 'players_teams.id_players', 'players.id')
        ->join('events_teams','events_teams.id_teams','players_teams.id_teams')
        ->where('events_teams.id_events', $event->id)
        ->select('players.name as name', 'players.surname as surname', 'players.id as id',
        'events_teams.id_events as eventId', 'events_teams.id_teams as teamId')
        ->get();

        $scores= $this->findScores($event);


        return view('eventedit')
        ->with('event',$event)
        ->with('scores', $scores)
        ->with('referees',Referee::all())
        ->with('countries',Country::all())
        ->with('sports',Sport::all())
        ->with('leagues',League::all())
        ->with('players',$players)
        ->with('teams',Team::all())
        ->with('eventTeams', $eventTeams);
    }

    private function findScores($event){
        if($event->typeResult == 'points_sets'){
            return PointsSet::
            join('teams', 'teams.id', 'points_sets.id_teams')
            ->select('points_sets.rnumber_set as numberSet', 'points_sets.points_set as points',
            'teams.id as teamId', 'teams.name as teamName')
            ->where('id_results', $event->resultId)
            ->get();
        }
        if($event->typeResult == 'results_points'){
            return ResultPoint::join('teams', 'teams.id', 'results_points.id_teams')
            ->join('players', 'players.id', 'results_points.id_players')
            ->select('results_points.point as point',
            'players.id as playerId', 'players.name as playerName','players.surname as playerSurname' ,
            'teams.id as teamId', 'teams.name as teamName')
            ->where('id_results', $event->resultId)
            ->get();
        }
        if($event->typeResult == 'results_upward'){
            return ResultUpward::join('teams', 'teams.id', 'results_upward.id_teams')
            ->select('results_upward.result as result', 'results_upward.position as position',
            'teams.id as teamId', 'teams.name as teamName',)
            ->where('id_results', $event->resultId)
            ->get();
        }
        if($event->typeResult == 'results_downward'){

            return ResultDownward::join('teams', 'teams.id', 'results_downward.id_teams')
            ->select('results_downward.result as result', 'results_downward.position as position',
            'teams.id as teamId', 'teams.name as teamName')
            ->where('id_results', $event->resultId)
            ->get();
        }
        return "";

    }

    public function editEvent(Request $request, $id){
        $validation = $this->validateCreationRequest($request);

        if($validation !== 'ok')
            return $validation;
        
        try{
            $this->updateEvent($request,$id);
            $this->updateLeague($request,$id);
            return redirect('/event/edit/{id}');
        }
        catch (QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot edit event');
        }
    }

    private function updateEvent($request,$id){
        $event = Event::findOrFail($id);
        $event->name = $request->name;
        $event->details = $request->details;
        $event->relevance = $request->relevance;
        $event->date = $request->date;
        $event->id_countries = Country::where('name', $request -> countryName)->first()->id;
        $event->id_sports = Sport::where('name', $request->sportName)->first()->id;
        $event->save();
    }

    private function updateLeague(Request $request,$id){
        $league = League::where('name', $request->leagueName)->first()->id;
        $leagueName = DB::table('leagues_events')
        ->where('id_events', $id)
        ->update([
            'id_leagues'=> $league
        ]);
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

    private function validateCreationRequest(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'details' => 'required',
            'date' => 'required',
            'relevance' => 'required',
            'country' => 'required',
            'sport' => 'required',
            'referee' => 'required'
        ]);
        if ($validator->fails())
            return $validator->errors()->toJson();
    
        return 'ok';
    }

    private function addEventTeam($eventID, $teamID){

        EventTeam::create([
            'id_teams' => $teamID,
            'id_events' => $eventID
        ]);

    }

    private function addReferee(Request $request, $eventID){

        RefereeEvent::create([
            'id_referee' => $request->referee,
            'id_events' => $eventID,
            'dates' => $request-> date
        ]);

    }
    
    private function addLeague(Request $request, $eventID){
        DB::table('leagues_events')->insert([
            'id_events'=>$eventID,
            'id_leagues'=>$request->league,
        ]);
    }

    public function createEventSet(Request $request){

        $validation = $this->validateCreationRequest($request);
        
        if($validation !== "ok"){
            return $validation;
        }
        try{

            $event = $this->createEvent($request);
            $result = $this->addSetResult($request, $event->id);

            $this->addEventTeam($event->id, $request->localTeam);
            $this->addEventTeam($event->id, $request->visitorTeam);

            if($request->referee != null)
                $this->addReferee($request, $event->id);

            if($request->league != null)
                $this->addLeague($request, $event->id);

            if($request->resultReady != null)
                $this->addSet($request, $event->id, $result);

            return redirect('/event');
        }
        catch(QueryException $e){

            return $e;

        }
           
    }

    private function addSetResult(Request $request, $eventID){
        return $result = DB::table('results')->insertGetId([
            'type_results'=>"points_sets",
            'results'=>" ",
            'id_events'=>$eventID
        ]);
    }

    private function addSet(Request $request, $eventID, $result){

        $this->addSetTeam($result, $request->input('setsLocal'), $request->localTeam);
        $this->addSetTeam($result, $request->input('setsVisitor'), $request->visitorTeam);

    }

    private function addSetTeam($result, $teamSet, $teamID){
        $setNumber = 0;

        foreach($teamSet as $set){

            $setNumber++;  

            DB::table('points_sets')->insert([
              'number_set' => $setNumber,
              'points_set' => $set,
              'id_teams' => $teamID,
              'id_results'=> $result
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
            $result = $this->addPointResult($request, $event->id);

            $this->addEventTeam($event->id, $request->localTeam);
            $this->addEventTeam($event->id, $request->visitorTeam);
            

            if($request->referee != null)
                $this->addReferee($request, $event->id);

            if($request->league != null)
                $this->addLeague($request, $event->id);

            if($request->resultReady !=null)
                $this->addPoint($request, $event->id, $result);

            return redirect('/event');

        }
        catch(QueryException $e){

            return $e;

        }

    }


    private function addPointResult(Request $request, $eventID){
        return $result = DB::table('results')->insertGetId([
            'type_results'=>"results_points",
            'results'=>" ",
            'id_events'=>$eventID
        ]);
    }

    private function addPoint(Request $request, $eventID, $result){

        $this->addPointTeam($result, $request->pointsLocal, $request->localTeam);
        $this->addPointTeam($result, $request->pointsVisitor, $request->visitorTeam);
    }

    private function addPointTeam($result, $points, $team){

        foreach($points as $point){
    
            DB::table('results_points')->insert([
                'id_players' => $point['player'],
                'point' => $point['points'],
                'id_teams' => $team,
                'id_results'=> $result
            ]);
    
        }

    }

    public function createEventMarkUp(Request $request){

        $validation = $this->validateCreationRequestForMarks($request);

        if($validation !== "ok"){
            return $validation;
        }
        try{
            $event = $this->createEvent($request);
            $result = $this->addMarkUpResult($request, $event->id);

            foreach($request->marks as $mark){
                $this->addEventTeam($event->id, $mark["team"]);
            }

            if($request->referee != null)
                $this->addReferee($request, $event->id);

            if($request->league != null)
                $this->addLeague($request, $event->id);

            if($request->resultReady !=null)
                $this->addMarkUp($request->marks, $event->id, $result);

            return redirect('/event');
        }
        catch(QueryException $e){

            return $e;

        }

    }
    private function validateCreationRequestForMarks($request){
        $validation = $this->validateCreationRequest($request);
        if($validation !== "ok"){
            return $validation;
        }
        $validation = $this->validateMarks($request);
        if($validation !== "ok"){
            return $validation;
        }
        return "ok";
    }
    private function validateMarks($request){
        $validation = Validator::make($request->all(),[
            'marks' => 'required'
        ]);
        if ($validation->fails())
            return $validation->errors()->toJson();
    
        return 'ok';
    }


    private function addMarkUpResult(Request $request, $eventID){
        return $result = DB::table('results')->insertGetId([
            'type_results'=>"results_upward",
            'results'=>" ",
            'id_events'=>$eventID
        ]);
    }

    private function addMarkUp($marks, $eventID, $resultId){
        usort($marks, function($a, $b){
            if ($a["mark"] == $b["mark"]) {
                return 0;
            }
            return ($a["mark"] < $b["mark"]) ? -1 : 1;
        });

        $result = Result::find($resultId);
        $result->results = Team::find(reset($marks)['team'])->name . " winer";
        $result->save();

        $position = 1;
        foreach($marks as $mark){
            DB::table('results_upward')->insert([
                'id_teams' => $mark["team"],
                'result' => $mark["mark"],
                'position' => $position,
                'id_results'=> $resultId
            ]);

            $position++;
        }

    }

    public function createEventMarkDown(Request $request){

        $validation = $this->validateCreationRequestForMarks($request);
        

        if($validation !== "ok"){
            return $validation;
        }
        try{
            $event = $this->createEvent($request);
            $result = $this->addMarkUpResult($request, $event->id);
            foreach($request->marks as $mark){
                $this->addEventTeam($event->id, $mark["team"]);
            }

            if($request->referee != null)
                $this->addReferee($request, $event->id);

            if($request->league != null)
                $this->addLeague($request, $event->id);

            if($request->resultReady !=null)
                $this->addMarkDown($request->marks, $event->id, $result);

            return redirect('/event');
        }
        catch(QueryException $e){

            return $e;

        }
    }

    private function addMarkDownResult(Request $request, $eventID, $result){
        return $result = DB::table('results')->insertGetId([
            'type_results'=>"results_downward",
            'results'=>" ",
            'id_events'=>$eventID
        ]);
    }

    private function addMarkDown($marks, $eventID, $resultId){
        usort($marks, function($a, $b){
            if ($a["mark"] == $b["mark"]) {
                return 0;
            }
            return ($a["mark"] > $b["mark"]) ? -1 : 1;
        });

        $result = Result::find($resultId);
        $result->results = Team::find(reset($marks)['team'])->name . " winer";
        $result->save();

        $position = 1;
        foreach($marks as $mark){
            DB::table('results_downward')->insert([
                'id_teams' => $mark["team"],
                'result' => $mark["mark"],
                'position' => $position,
                'id_results'=> $resultId
            ]);

            $position++;
        }

    }

    public function destroy($id){

        try{

            return $this->delete($id);

        }
        catch(QueryExepction $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot destroy event');
        };

    }

    private function delete($id){

        $this->deleteTeam($id);
        $this->deleteLeague($id); 
        
        if(Result::where('id_events',$id)->count() > 0){
            $this->deleteTypeResult($id);
            $this->deleteResult($id); 
        }
        
        $this->deleteReferee($id);

        Event::findOrFail($id)->delete();
        return redirect('/event/list');


    }

    private function deleteTeam($id){

        DB::table('events_teams')
        ->join('teams','teams.id','events_teams.id_teams')
        ->where('events_teams.id_events',$id)
        ->update(['events_teams.deleted_at'=>Carbon::now()]);
        
    }

    private function deleteLeague($id){

        $league = DB::table('leagues_events')
        ->join('leagues','leagues.id','leagues_events.id_leagues')
        ->where('leagues_events.id_events',$id);

        if($league->count() > 0){
            $league->update(['leagues_events.deleted_at'=>Carbon::now()]);
        }
        
        
    }
    
    private function deleteReferee($id){
        
        DB::table('referee_events')
        ->join('referee','referee.id','referee_events.id_referee')
        ->where('referee_events.id_events',$id)
        ->update(['referee_events.deleted_at'=>Carbon::now()]);
        
    }
        
    private function deleteResult($id){
            
        DB::table('results')
        ->where('id_events',$id)
        ->update(['results.deleted_at'=>Carbon::now()]);
    }

    private function deleteTypeResult($id){

        $result = Result::where('id_events',$id)->first();
        DB::table($result->type_results)->where('id_results',$result->id)->update(['deleted_at'=>Carbon::now()]);
 
    }

}

