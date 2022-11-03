<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Result;
use App\Models\Team;

class EventController extends Controller
{
   
    /*
        1. Index en Landing Page 
            Filtrar por: relevancia

            (   ) (   ) (   )
            (   ) (   ) (   )
            (   ) (   ) (   )

            TODOS LOS EVENTOS + RESULTADOS

        2. Index en Scores
            -> Filtrar por: fecha, deporte, pais.


        3. Index en Evento
        4. Index en Feed Usuario
            -> Filtrar por: equipos favoritos
        5. Index en Perfil Equipo
            -> Filtrar por: evento relevante al equipo
            
        
        $eventBySet = DB::table('AllEvents')
        ->join('points_sets', 'AllEvents.resultId', 'points_sets.id_results')->get();

        $eventByPoint = DB::table('AllEvents')
        ->join('results_points', 'AllEvents.resultId', 'results_points.id_results')->get();

        $eventByMarkUp = DB::table('AllEvents')
        ->join('results_points', 'AllEvents.resultId', 'results_points.id_results')->get();

        $eventByMarkDown = DB::table('AllEvents')
        ->join('results_points', 'AllEvents.resultId', 'results_points.id_results')->get();


        array[] lindo

        foreach($eventBySet as set)

            -> array lindo
        
    */

    public function IndexCards(Request $request){

        //Traenros los eventos
        //con sus resultados
        // ->join('events_teams','events_teams.id_events','events.id')
        // ->join('teams','teams.id','events_teams.id_teams')
        // $resultByScore = $event->join('results_points','results_points.id_results','results.id');
        
        $events = DB::table('events')
        ->join('leagues_events','leagues_events.id_events','events.id')
        ->join('leagues','leagues_events.id_leagues','leagues.id')
        ->join('results','results.id_events','events.id')
        ->join('countries','countries.id','events.id_countries')
        ->join('sports','sports.id','events.id_sports')
        ->select('events.id as id','events.name as name','events.relevance as relevance','events.date as date','results.type_results as type','results.id as idResults','leagues.name as league','sports.name as sport','countries.name as country')
        ->get();
        foreach($events as $event){
            $event->teams = DB::table('teams')->join('events_teams','events_teams.id_events','teams.id')
            ->where('id_events',$event->id)
            ->select('teams.name as name','teams.photo as photo')
            ->get();
            if($events->type = "results_points"){
                $event->results = DB::table('results_points')
                ->where('results_points.id_results',$event->idResults)
                ->select('point as point')
                ->get();
            }

            if($events->type = "points_sets"){
                $event->results = DB::table('points_sets')
                ->where('points_sets.id_results',$event->idResults)
                ->select('number_set as set','points_set as point')
                ->get();
            }
            if($events->type = "results_upward"){
                $event->results = DB::table('results_upward')
                ->where('id_results',$event->idResults)
                ->select('position as position','result as result')
                ->get();
            }
            if($events->type = "results_downward"){
                $event->results = DB::table('results_downward')
                ->where('id_results',$event->idResults)
                ->select('position as position','result as result')
                ->get();
            }
        }
        
        dd($events);
        
        }

}
