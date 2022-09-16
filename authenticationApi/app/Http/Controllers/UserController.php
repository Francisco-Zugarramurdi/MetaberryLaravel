<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\users_data;
use \Illuminate\Database\QueryException;


class UserController extends Controller
{
    public function create(Request $request){
        
        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok")
            return $validation;
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

    public function authenticate(Request $request){

        $validation =  $this->validateAuthenticationRequest($request);

        if($validation !== "ok")
            return $validation;
        return $this->authenticateUser($request->only('email', 'password'));
        
    }

    private function validateCreationRequest($request){

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|regex:/^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
            'password' => 'regex:^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
            'password_confirmation' => 'required'
        ]);
        
        if($validator->fails())
            return $validator->errors()->toJson();

        if(User::where('email', $request -> post("email")) -> exists())

            return 'User already exists';

        if($request->post("password") !== $request->post("password_confirmation"))

            return 'error: Passwords do not match'; 

        return 'ok';
    }

    private function createUser($request){

        $user = users_data::create([

            'name' => $request -> post("name"),
            'credit_card' => '',
            'photo' => '',
            'points' => 0,
            'type_of_user' => "free",
            'total_points' => 0

        ]);
        return User::create([

            'id' => $user -> id,
            'name' => $request -> post("name"),
            'email' => $request -> post("email"),
            'password' => Hash::make($request -> post("password"))

        ]);
    }

    private function validateAuthenticationRequest($request){

        $validator = Validator::make($request->all(),[

            'email' => 'required|regex:/^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
            'password' => 'required'

        ]);

        if ($validator->fails())
            return $validator->errors()->toJson();         
        $target = User::where('email',$request->post("email"))->first();

        if(!$target)
            return 'error: Authentication failure, invalid email'; 
        return "ok";
    }

    private function authenticateUser($credentials){

        if(!Auth::attempt($credentials))
            return 'error: Authentication failure, invalid password or email';
        return 'Success';
    }
}
