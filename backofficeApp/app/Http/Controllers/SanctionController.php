<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sanction;
use App\Models\Player;
use App\Models\Event;
class SanctionController extends Controller
{
    public function index(){
        
        return view('sanctions')->with('sanctions',Sanction::all())->with('events',Event::all());
    }

}
