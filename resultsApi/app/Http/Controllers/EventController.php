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

        // $mergedCollection = $events->toBase()->merge($team);

        // dd($mergedCollection);
        // //validate

        $events = DB::table('AllEvents')->get();
        $points = DB::table('AllEvents')->join('results_points', 'AllEvents.resultId', 'results_points.id_results')->get();
        $sets = DB::table('AllEvents')->join('points_sets', 'AllEvents.resultId', 'points_sets.id_results')->get();
        $markUp = DB::table('AllEvents')->join('results_upward', 'AllEvents.resultId', 'results_upward.id_results')->get();
        $markDown = DB::table('AllEvents')->join('results_downward', 'AllEvents.resultId', 'results_downward.id_results')->get();


        $indexEvent = $events->toBase()->merge([$points, $sets, $markUp, $markDown]);

        dd($indexEvent);

    }

}
