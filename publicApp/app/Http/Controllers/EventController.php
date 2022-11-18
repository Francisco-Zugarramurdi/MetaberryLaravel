<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventController extends Controller
{
    public function IndexSport(){
        return  json_decode(Http::get('http://localhost:8001/api/indexsport/'),true); 
    }
    public function IndexCountry(){
        return json_decode(Http::get('http://localhost:8001/api/indexcountry/'),true);
    }
    public function Index(){
        $events =  json_decode(Http::get('http://localhost:8001/api/index/'),true);

        usort($events, function($a, $b){
            if ($a["relevance"] == $b["relevance"]) {
                return 0;
            }
            return ($a["relevance"] > $b["relevance"]) ? -1 : 1;
        });

        return $events;
    }
    public function IndexEvent(Request $request, $id){
       $info=(json_decode(Http::get('http://localhost:8001/api/index/'.$id),true));
       $user_data = $this->getUserData($request);

       return view('events')->with('info',$info)->with('data', $user_data);

    }

    public function IndexEventMark(Request $request, $id){
        $info=(json_decode(Http::get('http://localhost:8001/api/index/'.$id),true));
        $user_data = $this->getUserData($request);
        return view('eventsmark')->with('info',$info)->with('data', $user_data);
 
     }

     public function IndexEventSet(Request $request, $id){
        $info=(json_decode(Http::get('http://localhost:8001/api/index/'.$id),true));
        $user_data = $this->getUserData($request);
        return view('eventsset')->with('info',$info)->with('data', $user_data);
 
     }

    private function getUserData(Request $request){

        $id = $request->session()->get('user_id');

        $response = Http::get('http://localhost:8000/api/user/'. $id);
        $user_data = json_decode($response, true);
        
        return $user_data;

    }
}
