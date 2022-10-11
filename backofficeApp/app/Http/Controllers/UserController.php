<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserData;
use \Illuminate\Database\QueryException;
class UserController extends Controller
{

    public function create(Request $request){

        $validation = $this->validateRequest($request);

        if($validation !== "ok"){
            return $validation;
        }
        try {
            return $this->createUser($request);
        }
        catch (QueryException $e){

            return [
                "error" => 'Cannot create user',
                "trace" => $e -> getMessage()
            ];

        }
        
    }

    private function validateRequest(Request $request){

        $validationRequest = $this->validateCreationRequest($request);

        if($validationRequest !== "ok")
            return $validationRequest;

        $validationRegexRequest = $this->validateRegexRequest($request);

        if($validationRegexRequest !== "ok")
            return $validationRegexRequest;
        return "ok";

    }

    private function validateRegexRequest(Request $request){

        $validator = Validator::make($request->all(),
        
        [

            'email' => 'regex:/(?i)^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
            'password' => 'regex:^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
            'credit_card' => 'regex:/^4[0-9]{12}(?:[0-9]{3})?$/',
            'photo' => 'regex:/(?i)^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            
        ]);

        if($validator->fails())
            return $validator->errors()->toJson();
        return 'ok';

    }

    private function validateCreationRequest(Request $request){

        $validator = Validator::make($request->all(),[

            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'photo' => 'required',
            'points' => 'required',
            'type_of_user' => 'required',
            'total_points' => 'required'

        ]);

        if($validator->fails())
            return $validator->errors()->toJson();

        if(User::withTrashed()->where('email', $request -> post("email")) -> exists())
            return 'User already exists';

        return 'ok';

    }

    private function createUser(Request $request){

        $user = UserData::create([

            'name' => $request -> post("name"),
            'credit_card' => $request -> post("credit_card"),
            'photo' => $request -> post("photo"),
            'points' => $request -> post("points"),
            'type_of_user' => $request -> post("type_of_user"),
            'total_points' => $request -> post("total_points")

        ]);
        
        User::create([

            'id' => $user ->id,
            'name' => $request -> post("name"),
            'email' => $request -> post("email"),
            'password' => Hash::make($request -> post("password"))

        ]);
        return redirect('/user');

    }

    public function indexByEmail($email){

        $user = User::where('email', $email)->first();

        if (! $user) 
            return "error User" . $email . "does not exist";
            
        return $user;

    }

    public function index(){
        $users = UserData::join('users','users.id','=','users_data.id')->get();
        return view('users')->with('users',$users);

    }

    public function update(Request $request, $id){

        $validation = $this->validateRegexRequest($request);
        if($validation !== "ok")
            return $validation;
        
        try{
                
            $this->updateUserData($request, $id);
            $this->updateUserCredentials($request, $id);

            return redirect('/user');
            
        }
        catch (QueryException $e){

            return [
                "error" => 'Cannot update user',
                "trace" => $e -> getMessage()
            ];
            
        }

    }

    private function updateUserData(Request $request,$id){
        $user= UserData::findOrFail($id);
        $user -> name = $request -> name;
        $user -> credit_card = $request-> credit_card;
        $user -> photo = $request -> photo;
        $user -> points = $request -> points;
        $user -> type_of_user = $request -> type_of_user;
        $user -> total_points = $request -> total_points;
        $user-> save();

    }

    private function updateUserCredentials(Request $request, $id){
        $user = User::findOrFail($id);
        $user -> name = $request -> name;
        $user -> email = $request -> email;
        $user-> save();

    }

    public function destroy($id){
        try{
            $user = User::findOrFail($id);
            $userData = UserData::findOrFail($id);
            $user->delete();
            $userData->delete();
            return redirect('/user');
        }
        catch(QueryException $e){
            return [
                "error" => 'Cannot delete user',
                "trace" => $e -> getMessage()
            ];
        }
        
    }


}