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

        $validation = $this->validateCreationRequest($request);

        if($validation['status'] !== "Success")
            return $validation;
        try {
            return $this->createUser($request);
        }
        catch (QueryException $e){

            return [
                "status" => "Error",
                "body" => $e->getMessage()
            ];

        }
    }

    private function validateCreationRequest($request){

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|regex:/(?i)^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
            'password' => 'required|regex:^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
            'password_confirmation' => 'required'
        ]);
        
        if($validator->fails())
            return $validator->errors()->toJson();

        if(User::where('email', $request -> post("email")) -> exists())

            return [
                "status" => "Error",
                "body" => "User already exists"
            ];

        if($request->post("password") !== $request->post("password_confirmation"))

            return [
                "status" => "Error",
                "body" => "Passwords do not match"
            ];

        return [
            "status" => "Success",
            "body" => "Created succesfully"
        ];
    }

    private function createUser($request){

        $user = UserData::create([

            'name' => $request -> post("name"),
            'credit_card' => '',
            'photo' => 'default_img_do_not_delete.jpg',
            'points' => 0,
            'type_of_user' => 'free',
            'total_points' => 0

        ]);

        User::create([

            'id' => $user -> id,
            'name' => $request -> post("name"),
            'email' => $request -> post("email"),
            'password' => Hash::make($request -> post("password"))

        ]);

        return [
            "status" => "Success",
            "body" => "Created succesfully",
            "photo" => $user->photo
        ];
    }

    public function authenticate(Request $request){

        $validation =  $this->validateAuthenticationRequest($request);
        
        $userPhoto = UserData::join('users','users.id','users_data.id')
        ->where('email',$request->email)
        ->select('photo as photo')
        ->first()
        ->photo;
                
        if($validation['status'] !== "Success")
            return $validation;
        return $this->authenticateUser($request->only('email', 'password'),$userPhoto);
        
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
            return [
                "status" => "Error",
                "body" => "Invalid credentials"
            ];
        return [
            "status" => "Success",
            "body" => "Validated succesfully"
        ];
    }

    private function authenticateUser($credentials,$photo){

        if(!Auth::attempt($credentials))
            return [
                "status" => "Error",
                "body" => "Invalid credentials"
            ];
        return [
            "status" => "Success",
            "body" => "Authenticated",
            "photo" => $photo
        ];
    }
}
