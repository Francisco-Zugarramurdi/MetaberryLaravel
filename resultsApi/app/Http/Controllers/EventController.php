<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Result;

class EventController extends Controller
{
    public function Index($id){
        //validar

        try{
            return $this->handleIndex($id);        
        }
        catch(QueryException $e){
            return $e;
        }
    
    }
    private function handleIndex($id){
        $event = Event::findOrFail($id);
        $result = Result::where('id_events',$id);
        
    }
    private function handleResults($result){
        if($result->type_results == 'points_sets'){
            $this->handleResultSet();
        }
        if($result->type_results == 'results_points'){
            $this->handleResultSet();
        }
        if($result->type_results == 'results_upward'){
            $this->handleResultSet();
        }
        if($result->type_results == 'results_downward'){
            $this->handleResultSet();
        }
    }

}
