<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    public function GetIndexView(Request $request){

        $user_data = $this->getUserData($request);
        $followed_events = $this->getFollowedEvents($request);

        return view('user-profile')
        ->with('data', $user_data)
        ->with('events', $followed_events);

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

        $data = $this->getUserData($request);

        if($user_data['status'] != "Success"){

            return view('edit-user-profile',[ 'error' => true, 'body' => $user_data['body'], 'data' => $data]);
            
        }
        return redirect("/user");
        
    }

    public function Suscribe(Request $request){

        $id = $request->session()->get('user_id');

        $response = Http::post('http://localhost:8000/api/user/subscription/'. $id, [
            'type_of_user'=> $request->type_of_user,
            'credit_card' => $request->credit_card
        ]);

        $user_data = json_decode($response, true);

        if($user_data['status'] == "Success"){

            $request->session()->put('user_sub', $user_data['user_subscription']);
            $request->session()->save();

            return redirect("/user")->with('data', $user_data);
    
        }
        
        return view('subscribe',[ 'error' => true, 'body' => $user_data['body'], 'data' => $user_data]);

    }

    public function DeleteSubscription(Request $request){

        $id = $request->session()->get('user_id');

        $response = Http::delete('http://localhost:8000/api/user/subscription/'. $id);

        $user_data = json_decode($response, true);

        if($user_data['status'] == "Success"){

            $request->session()->forget('user_sub');
        }
        
        return redirect("/user")->with('data', $user_data);
    }

    public function UpdateSubscription(Request $request){

        $id = $request->session()->get('user_id');

        $response = Http::put('http://localhost:8000/api/user/subscription/'. $id,[

            'type_of_user'=> $request->type_of_user

        ]);

        $user_data = json_decode($response, true);

        if($user_data['status'] == "Success"){

            $request->session()->forget('user_sub');
            $request->session()->put('user_sub', $user_data['user_subscription']);
            $request->session()->save();
            
            return redirect("/user")->with('data', $user_data);
        }
        
    }

    public function FollowEvent(Request $request){

        $id = $request->session()->get('user_id');

        $response = Http::post('http://localhost:8001/api/follow/'. $request->event_id .'/'. $id);

        $user_data = json_decode($response, true);

        return redirect('/user')->with('data', $user_data);

    }

    public function UnfollowEvent(Request $request){

        $id = $request->session()->get('user_id');

        $response = Http::post('http://localhost:8001/api/unfollow/'. $request->event_id .'/'. $id);

        $user_data = json_decode($response, true);

        return redirect('/user')->with('data', $user_data);

    }

    private function getFollowedEvents(Request $request){

        $id = $request->session()->get('user_id');

        $response = Http::get('http://localhost:8001/api/following/'. $id);
        $user_data = json_decode($response, true);
        
        return $user_data;

    }
}
