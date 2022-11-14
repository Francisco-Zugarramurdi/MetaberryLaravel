<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserData;
use \Illuminate\Database\QueryException;
use Carbon\Carbon;

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

        if(User::where('email', $request -> post("email")) -> exists()){

            return [
                "status" => "Error",
                "body" => "User already exists"
            ];

        }

        if($request->post("password") !== $request->post("password_confirmation")){

            return [
                "status" => "Error",
                "body" => "Passwords do not match"
            ];

        }

        return [
            "status" => "Success",
            "body" => "Created succesfully"
        ];
    }

    private function validateRegexRequest(Request $request){

        $validator = Validator::make($request->all(),
        [

            'email' => 'regex:/(?i)^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
            'password' => 'regex:^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^'
            
        ]);

        if($validator->fails())
            return $validator->errors()->toJson();
        return [
            "status" => "Success",
            "body" => "Validated succesfully"
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
            "id" => $user->id
        ];
    }

    public function authenticate(Request $request){

        $validation =  $this->validateAuthenticationRequest($request);

        if($validation['status'] !== "Success")
            return $validation;
        return $this->authenticateUser($request->only('email', 'password'));
        
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

    private function authenticateUser($credentials){

        if(!Auth::attempt($credentials))
            return [
                "status" => "Error",
                "body" => "Invalid credentials"
            ];
        return [
            "status" => "Success",
            "body" => "Authenticated",
            "id" => Auth()->user()->id
        ];
    }

    public function Index($id){

        return User::join('users_data','users_data.id','users.id')
        ->where('users.id', $id)
        ->select('users.id as id','users_data.photo as photo','users_data.name as name','users.email as email')
        ->first();

    }

    public function Update(Request $request, $id){

        $validatePassword = $this->validatePasswordUpdate($request, $id);
        $validateEmail = $this->validateEmailUpdate($request, $id);
        
        if($validateEmail['status'] !== "Success")
            return $validateEmail;

        if($validatePassword['status'] !== "Success")
            return $validatePassword;
        
        try{
                
            $this->updateUserData($request, $id);
            $this->updateUserCredentials($request, $id);

            return [
                "status" => "Success",
                "body" => "User updated succesfully"
            ];
            
        }
        catch (QueryException $e){

            return [
                "status" => "Error",
                "body" => $e->getMessage()
            ];
            
        }

    }

    private function updateUserData(Request $request, $id){

        $user = UserData::findOrFail($id);
        $user -> name = $request -> name;
        $user -> save();

    }
    
    private function validateEmailUpdate(Request $request, $id){

        if(!$request->filled('email')){

            return [
                "status" => "Success",
                "body" => "Validated succesfully"
            ];

        }

        
        $regexEmail = $this->validateEmailRegex($request);
        
        if($regexEmail['status'] !== "Success"){
            
            return $regexEmail;
            
        }
        
        $emailExists = User::withTrashed()->where('email', $request -> email)->exists();
        
        if(User::findOrFail($id)->email == $request -> email || !$emailExists){
            
            return [
                "status" => "Success",
                "body" => "Validated succesfully"
            ];
            
        }
        
        return [
            "status" => "Error",
            "body" => "User already exists"
        ];
            
    }

    private function validateEmailRegex(Request $request){

        $validator = Validator::make($request->all(),
        [
            'email' => 'regex:/(?i)^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix'
        ]);

        if($validator->fails())
            return $validator->errors()->toJson();
        return [
            "status" => "Success",
            "body" => "Validated succesfully"
        ];

    }

    private function validatePasswordUpdate(Request $request){

        if(!$request->filled('password')){

            return [
                "status" => "Success",
                "body" => "Validated succesfully"
            ];

        }
        
        $validator = Validator::make($request->all(),
        [
            'password' => 'regex:^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^'
        ]);
    
        if($validator->fails())
            return $validator->errors()->toJson();
        return [
            "status" => "Success",
            "body" => "Validated succesfully"
        ];

    }

    private function updateUserCredentials(Request $request, $id){
        
        $user = User::findOrFail($id);
        $user -> name = $request -> name;
        $user -> email = $request -> email;

        if($request->filled('password'))
            $user -> password = Hash::make($request -> post("password"));

        $user-> save();

    }
}
