<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    public function getUserData(Request $request){

        $id = $request->session()->get('user_id');

        $response = Http::get('http://localhost:8000/api/user/'. $id);
        $user_data = json_decode($response, true);
        
        return $user_data;

    }

    public function Update(Request $request){

        $id = $request->session()->get('user_id');

        $response = Http::post('http://localhost:8000/api/user/'. $id, [
            'email'=> $request->email,
            'name'=> $request->name,
            'password'=> $request->password
        ]);

        $user_data = json_decode($response, true);

        return redirect("/user");
        
    }

}
