<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;

class AuthController extends Controller
{
    public function Login(Request $request){

        $response = Http::post('http://localhost:8000/api/user/authenticate',[
            'email'=> $request->email,
            'password'=> $request->password
        ]);

        $authentication = json_decode($response,true);

        if($authentication['status'] == "Success"){

            $request->session()->put('authenticated', true);
            $request->session()->put('user_id', $authentication['id']);
            $request->session()->save();
            
            return redirect("/");

        }

        return view('/log-in',[ 'error' => true, 'body' => $authentication]);

    }

    public function Sign(Request $request){

        $response = Http::post('http://localhost:8000/api/user/create',[
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation
        ]);

        $authentication = json_decode($response,true);

        if($authentication['status'] == "Success"){

            $request->session()->put('authenticated', true);
            $request->session()->put('user_id', $authentication['id']);
            $request->session()->save();
            return redirect('/');
        }
        return view('/sign-up',[ 'error' => true, 'body' => $authentication]);

    }

    public function Logout(Request $request){

        $request->session()->invalidate();
        return redirect("/");

    }
}
