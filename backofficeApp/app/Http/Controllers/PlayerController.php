<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
class PlayerController extends Controller
{
    public function index(){
        return view('players')->with('players',Player::all());
        
    }
}
