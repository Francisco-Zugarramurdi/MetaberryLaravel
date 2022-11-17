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

            $request->session()->regenerate();
            $request->session()->put('authenticated', true);
            $request->session()->put('user_id', $authentication['id']);
            $request->session()->save();
            
            return redirect("/scores");

        }

        return view('log-in',[ 'error' => true, 'body' => $authentication['body']]);

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

            return $this->validateRedirection($request);

            
        }

        return view('sign-up',[ 'error' => true, 'body' => $authentication['body']]);

    }

    private function validateRedirection(Request $request){

        $validateRedirect = $this->redirectIntendedView($request);

        if($validateRedirect['redirecting'] == 'Redirect to Intended View'){

            return view($validateRedirect['body']);

        }
        return redirect("/scores");

    }

    private function redirectIntendedView(Request $request){
        
        if (session()->has('intendedView')) {
            
            $redirectTo = session()->get('intendedView');
            session()->forget('intendedView');
            
            return [
                "redirecting" => 'Redirect to Intended View',
                "body" => $redirectTo
            ];

        }

        return [
            "redirecting" => 'Redirect to Scores',
            "body" => '/scores'
        ];

    }

    public function Logout(Request $request){

        $request->session()->invalidate();
        $request->session()->flush();
        return redirect("/");

    }
}
