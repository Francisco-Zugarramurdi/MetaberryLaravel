<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    public function GetIndexView(Request $request){

        $user_data = $this->getUserData($request);

        return view('user-profile')->with('data', $user_data);

    }

    public function GetEditView(Request $request){

        $user_data = $this->getUserData($request);

        return view('edit-user-profile')->with('data', $user_data);

    }

    public function GetScoreView(Request $request){

        $user_data = $this->getUserData($request);

        return view('scores')->with('data', $user_data);

    }

    public function GetLandingView(Request $request){

        $user_data = $this->getUserData($request);

        return view('landing')->with('data', $user_data);

    }

    private function getUserData(Request $request){

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

    public function UpdateSubscription(Request $request){

        $id = $request->session()->get('user_id');

        $response = Http::post('http://localhost:8000/api/user/subscription/'. $id, [
            'type_of_user'=> $request->type_of_user,
            'credit_card' => $request->credit_card
        ]);

        $user_data = json_decode($response, true);

        return redirect("/user")->with('data', $user_data);

    }

}
