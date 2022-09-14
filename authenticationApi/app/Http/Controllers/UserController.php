<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\users_data;
class UserController extends Controller
{
    public function Create(Request $request){
        $validation = $this->validateCreationRequest($request);
        if($validation !== "ok")
            return $validation;
        try {
            return $this->createUser($request);
        }
        catch (QueryException $e){
            return $this->handleCreationErrors($e,$request->post("name"));
        }
    }

    public function Authenticate(Request $request){
        $validation =  $this->validateAuthenticationRequest($request);
        if($validation !== "ok")
            return $validation;
        return $this->AuthenticateUser($request->only('email', 'password'));
        
    }

    private function validateCreationRequest($request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|regex:/^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
            'password' => 'required|regex:^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
            'password_confirmation' => 'required|regex:^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^'
        ]);
        if($validator->fails())
            return $validator->errors()->toJson();
        if($request->post("password") !== $request->post("password_confirmation"))
            return [ "password" => "Passwords are different, they must be the same"]; 
        return 'ok';
    }

    private function createUser($request){
        $user = users_data::create([
            'name' => $request -> post("name"),
            'points' => 0,
            'type_of_user' => "free",
            'total_points' => 0
        ]);
        
        return User::create([
            'id' => $user ->id,
            'name' => $request -> post("name"),
            'email' => $request -> post("email"),
            'password' => Hash::make($request -> post("password"))
        ]);
    }

    private function handleCreationErrors($e,$name){
        return [
            "error" => 'User ' . $name . ' exists',
            "trace" => $e -> getMessage()
        ];
    }
    private function validateAuthenticationRequest($request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|regex:/^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
            'password' => 'required|regex:^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
        ]);
        if ($validator->fails())
            return $validator->errors()->toJson();         
        $target = User::where('email',$request->post("email"))->first();
        if(!$target)
            return [ "email" => "User does not exist"]; 
        return "ok";
    }
    private function AuthenticateUser($credentials){
        if(!Auth::attempt($credentials))
            return ['status' => false];
        return ['status' => true];
    }
}
