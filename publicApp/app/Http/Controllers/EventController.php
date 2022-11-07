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
        return json_decode(Http::get('http://localhost:8001/api/index/'),true);
    }
}
