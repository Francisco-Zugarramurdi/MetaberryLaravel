<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Result;
use App\Models\Team;
use App\Models\Player;
use App\Models\PremiumEvent;
use Carbon\Carbon;

class EventController extends Controller
{
    public function IndexCountries(){

        return DB::table('countries')->where('deleted_at',null)->select('id as id','name as country')->get()->toArray();

    }

    public function IndexSports(){

        return DB::table('sports')->where('deleted_at',null)->select('id as id','name as sport', 'icon as icon')->get()->toArray();

    }

    public function IndexCards(Request $request){

        return $this->setEventCards($this->getEventsCards());

    }

    public function IndexEvent($id){

        $event = $this->getEventData($id);
        $event -> teams = $this->getTeamData($this->getTeam($id),$event->date,$event -> type, $event->resultsID);
        $event -> sanctions = $this->getSanctions($id); 
        
        foreach($event -> teams as $key => $team){
           
            if($event-> type == 'results_points'){
                $event -> teams[$key] -> result = $this->getResultPoint($event -> resultsID, $team -> id);  
                $event -> teams[$key] -> points = $this->loadPoints($this->getResultPoint($event -> resultsID, $team -> id));  
            }
            if($event-> type == 'points_sets'){
                $event->result = $this->getResultSetData($event->resultsID, $team->id);
            }
            if($event-> type == 'results_upward'){
                $event->result = $this->getResultUpwardData($event->resultsID, $team->id);
            }
            if($event-> type == 'results_downward'){
                $event->result = $this->getResultDownwardData($event->resultsID,$team->id);
            }
            
        }
        
        return $event;
    }

    private function getEventsCards(){

       return DB::table('events')
        ->leftJoin('leagues_events','leagues_events.id_events','events.id')
        ->leftJoin('leagues','leagues_events.id_leagues','leagues.id')
        ->join('results','results.id_events','events.id')
        ->join('countries','countries.id','events.id_countries')
        ->join('sports','sports.id','events.id_sports')
        ->where('events.deleted_at',null)
        ->select('events.id as id','events.name as name','events.relevance as relevance','events.date as date','results.type_results as type','results.id as idResults','leagues.name as league','sports.name as sport','countries.name as country')
        ->get()
        ->toArray();

    }

    private function setEventCards($events){

        foreach($events as $event){

            $event -> teams = $this->getTeam($event -> id);

            foreach($event -> teams as $key => $team){

                if($event -> type == "results_points"){
                    $event -> teams[$key] -> result = $this->getResultPoint($event -> idResults, $team -> id);   
                }
     
                if($event->type == "points_sets"){
                    $event->teams[$key]->result = $this->getResultSet($event -> idResults, $team -> id);
                }

                if($event->type == "results_upward"){
                    $event->teams[$key]->result = $this->getResultUpward($event -> idResults, $team -> id);
                }
                if($event->type == "results_downward"){
                    $event->teams[$key]->result = $this->getResultDownward($event -> idResults, $team -> id);
                }
            }
        }

        return $events;

    }

    private function getTeam($eventID){

        return DB::table('teams')
        ->join('events_teams','events_teams.id_teams','teams.id')
        ->where('id_events',$eventID)
        ->select('teams.id as id','teams.name as name','teams.photo as photo')
        ->get()->toArray();

    }

    private function getResultPoint($resultID, $teamID){

        return DB::table('results_points')
        ->join('players','players.id','results_points.id_players')
        ->join('teams','teams.id','results_points.id_teams')
        ->where('results_points.id_results',$resultID)
        ->where('results_points.id_teams',$teamID)
        ->select('results_points.point as point','players.id as playerId','players.name as namePlayer','players.surname as surnamePlayer','teams.name as teamName','teams.id as teamId')
        ->get()->toArray();

    }

    private function getResultSet($resultID, $teamID){

        return DB::table('points_sets')
        ->where('points_sets.id_results',$resultID)
        ->where('points_sets.id_teams',$teamID)
        ->select('number_set as set','points_set as point')
        ->get()->toArray();

    }
    
    private function getResultUpward($resultID, $teamID){
        
        return DB::table('results_upward')
        ->where('id_results',$resultID)
        ->where('id_teams',$teamID)
        ->select('position as position','result as result', 'unit as unit')
        ->get()
        ->toArray();
        
    }

    private function getResultDownward($resultID, $teamID){

        return DB::table('results_downward')
        ->where('id_results',$resultID)
        ->where('id_teams',$teamID)
        ->select('position as position','result as result', 'unit as unit')
        ->get()
        ->toArray();

    }

    private function getEventData($id){
        return DB::table('events')
        ->leftJoin('leagues_events','leagues_events.id_events','events.id')
        ->leftJoin('leagues','leagues_events.id_leagues','leagues.id')
        ->join('results','results.id_events','events.id')
        ->join('countries','countries.id','events.id_countries')
        ->join('sports','sports.id','events.id_sports')
        ->join('referee_events', 'referee_events.id_events','events.id')
        ->join('referee','referee_events.id_referee', 'referee.id')
        ->where('events.id', $id)
        ->select('events.id as id','events.name as name','events.relevance as relevance',
        'events.date as date','results.type_results as type','results.id as resultsID','results.results as resultwin','leagues.name as league',
        'sports.name as sport','countries.name as country', 'events.details as details')
        ->first();
    }

    private function loadPoints($points){
        $totalPoints=0;
       
        foreach($points as $point){

            $totalPoints += $point->point;

        }
       
        return  $totalPoints;
    }

    private function getTeamData($teams,$date,$type,$resultID){

        foreach($teams as $key => $team){
            
            $teams[$key]->player = $this->getPlayer($team->id,$date);
            $teams[$key]->extras = $this->getExtra($team->id,$date);

            if($type == 'results_points'){
                $teams[$key]->result = $this->getResultPointData($resultID);
                
            }
            if($type == 'points_sets'){
                $teams[$key]->result = $this->getResultSetData($resultID, $team->id);
            }
            if($type == 'results_upward'){
                $teams[$key]->result = $this->getResultUpwardData($resultID, $team->id);
            }
            if($type == 'results_downward'){
                $teams[$key]->result = $this->getResultDownwardData($resultID, $team->id);
            }
                
        }
        return $teams;
    }

    private function getPlayer($id,$date){
        return DB::table('players')
        ->join('players_teams','players_teams.id_players','players.id')
        ->where('players_teams.contract_start','<',$date)
        ->where('players_teams.contract_end', '>',$date)
        ->where('players_teams.id_teams',$id)
        ->select('players.id as playerID','players.name as name','players.surname as surname',
        'players.photo as photo')
        ->get()->toArray();
    }

    private function getExtra($id,$date){
        return DB::table('extras')
        ->join('extra_compose','extra_compose.id_extra','extras.id')
        ->where('extra_compose.id_teams',$id)
        ->where('extra_compose.contract_start','<',$date)
        ->where('extra_compose.contract_end', '>',$date)
        ->select('extras.id as extraID','extras.name as name','extras.surname as surname',
        'extras.photo as photo', 'extras.rol as rol')
        ->get()->toArray();
    }

    private function getSanctions($id){
          
        return  DB::table('sanctions')
        ->join('sanctions_players','sanctions_players.id_sancion','sanctions.id')
        ->join('players','sanctions_players.id_players', 'players.id')
        ->where('sanctions.id_events',$id)
        ->select('sanctions.id as sanctionID','sanctions.sancion as sanction','sanctions_players.id_players as sanctionPlayer',
        'sanctions_players.minute as minute', 'players.name as name','players.surname as surname')
        ->get()->merge( DB::table('sanctions')
        ->join('sanctions_extra','sanctions_extra.id_sancion','sanctions.id')
        ->join('extras','sanctions_extra.id_extra', 'extras.id')
        ->where('sanctions.id_events',$id)
        ->select('sanctions.id as sanctionID','sanctions.sancion as sanction','sanctions_extra.id_extra as sanctionExtra',
        'sanctions_extra.minute as minute', 'extras.name as name','extras.surname as surname')
        ->get())->toArray();
            
    }

    private function getResultPointData($resultID){

        return DB::table('results_points')
        ->join('players','results_points.id_players','players.id')
        ->join('players_teams', 'players.id','players_teams.id_players')
        ->join('teams', 'teams.id','players_teams.id_teams')
        ->where('results_points.id_results',$resultID)
        ->select('point as point','players.name as name','players.surname as surname',
        'players.photo as photo','teams.name as teamName','teams.id as teamId')
        ->get()->toArray();
        
    }

    private function getResultSetData($resultID){

        return DB::table('points_sets')
        ->join('teams','points_sets.id_teams','teams.id')
        ->where('points_sets.id_results',$resultID)
        ->select('number_set as set','points_set as point','points_sets.id_teams as team','teams.name as teamName')
        ->get()->toArray();

    }

    private function getResultUpwardData($resultID,  $teamID){

        return DB::table('results_upward')
        ->join('teams','results_upward.id_teams','teams.id')
        ->where('id_results',$resultID)
        ->select('position as position','result as result','results_upward.id_teams as team','teams.name as teamName','teams.photo as teamPhoto', 'results_upward.unit as unit')
        ->orderBy('position')->get()->toArray();

    }

    private function getResultDownwardData($resultID){

        return DB::table('results_downward')
        ->join('teams','results_downward.id_teams','teams.id')
        ->where('id_results',$resultID)
        ->select('position as position','result as result','results_downward.id_teams as team','teams.name as teamName','teams.photo as teamPhoto', 'results_downward.unit as unit')
        ->orderBy('position')->get()->toArray();

    }

    public function GetEventsBySport(Request $request){

        $events = DB::table('events')
        ->leftJoin('leagues_events','leagues_events.id_events','events.id')
        ->leftJoin('leagues','leagues_events.id_leagues','leagues.id')
        ->join('results','results.id_events','events.id')
        ->join('countries','countries.id','events.id_countries')
        ->join('sports','sports.id','events.id_sports')
        ->whereNull('events.deleted_at')
        ->where("events.id_sports", $request->idSport)
        ->select('events.id as id','events.name as name','events.relevance as relevance','events.date as date',
        'results.type_results as type','results.id as idResults',
        'leagues.name as league',
        'sports.name as sport',
        'countries.name as country')
        ->get()->toArray();

        $events = $this->setEventCards($events);
        
        return $events;


        
    }

    public function FollowEvent($event_id, $id){

        $following = PremiumEvent::create([

            'id_users_data' => $id,
            'id_events' => $event_id

        ]);

        return Event::findOrFail($event_id)->first();

    }

    public function UnfollowEvent($event_id, $id){

        return PremiumEvent::where('id_users_data', $id)
        ->where('id_events', $event_id)
        ->update(['deleted_at'=>Carbon::now()]);

    }

    public function GetFollowedEvents($id){

        return DB::table('events')
        ->join('premium_events','premium_events.id_events','events.id')
        ->where('premium_events.id_users_data', $id)
        ->where('premium_events.deleted_at', null)
        ->select('events.name as name','events.date as date','events.details as details','events.id as id')
        ->get()->toArray();

    }

}    
