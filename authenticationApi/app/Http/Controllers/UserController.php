<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserData;
use App\Models\UserSubscription;
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

        $error_messages = [
            'password.regex' => 
            'Password must have at least 8 characters, a number and a capital letter',
        ];

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|regex:/(?i)^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
            'password' => 'required|regex:^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
            'password_confirmation' => 'required'
        ], $error_messages);
        
        if($validator->fails()){

            return [
                "status" => "Error",
                "body" => $validator->errors()
            ];     

        }

        $error_array = [
            "User" => ["User already exists"]
        ];
        
        $error_obj = (object) $error_array;

        if(User::where('email', $request -> post("email")) -> exists()){

            return [
                "status" => "Error",
                "body" => $error_obj
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

        if ($validator->fails()){

            return [
                "status" => "Error",
                "body" => $validator->errors()
            ];     

        }
        return [
            "status" => "Success",
            "body" => "Validated succesfully"
        ];


    }

    private function createUser($request){

        $user = UserData::create([

            'name' => $request -> post("name"),
            'credit_card' => '',
            'photo' => $this->saveImage(),
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

    private function saveImage(){

        $image_array = [

            "avatar_01" => "avatar_01.png",
            "avatar_02" => "avatar_02.png",
            "avatar_03" => "avatar_03.png",
            "avatar_04" => "avatar_04.png"
        ];

        $rand_image = array_rand($image_array);

        return $image_array[$rand_image];

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

        if($validator->fails()){

            return [
                "status" => "Error",
                "body" => $validator->errors() 
            ];     

        }
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

        $error_array = [
            "User" => ["User already exists"]
        ];
        
        $error_obj = (object) $error_array;

        return [
            "status" => "Error",
            "body" => $error_obj
        ];
            
    }

    private function validateEmailRegex(Request $request){

        $validator = Validator::make($request->all(),
        [
            'email' => 'regex:/(?i)^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix'
        ]);

        if ($validator->fails()){

            return [
                "status" => "Error",
                "body" => $validator->errors()
            ];     

        }
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
    
        if ($validator->fails()){

            return [
                "status" => "Error",
                "body" => $validator->errors() 
            ];     

        }
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

    public function Suscribe(Request $request, $id){

        $validateCard = $this->validateRegexCreditCard($request);
        
        if($validateCard['status'] !== "Success")
            return $validateCard;

        try{
                
            return $this->updateOnSub($request, $id);

        }
        catch (QueryException $e){

            return [
                "status" => "Error",
                "body" => $e->getMessage()
            ];
            
        }

    }

    private function updateOnSub(Request $request, $id){

        $user = UserData::findOrFail($id);
        $user -> type_of_user = $request -> type_of_user;
        $user -> credit_card = $request -> credit_card;
        $user -> save();        

        UserSubscription::create([
    
            'id_users' => $id,
            'type_of_subscription' => $request -> type_of_user

        ]);

        return [
            "status" => "Success",
            "body" => "Suscription made successfully",
            "user_subscription" => $user -> type_of_user
        ];

    }

    private function validateRegexCreditCard(Request $request){

        $validator = Validator::make($request->all(),
        [
            'credit_card' => 'regex:/^4[0-9]{12}(?:[0-9]{3})?$/|nullable'
        ]);

        if ($validator->fails()){

            return [
                "status" => "Error",
                "body" => $validator->errors() 
            ];     

        }
        return [
            "status" => "Success",
            "body" => "Validated succesfully"
        ];

    }

    private function validateSubscriptionUpdate($request, $id){

        UserSubscription::where('id_users', $id)
        ->update([
            'type_of_subscription' => $request -> type_of_user
        ]);

    }

    public function DestroySubscription($id){

        try{

            $this->updateSubscriptionOnDelete($id);

            $subscription = UserSubscription::where('id_users', $id)
            ->where('deleted_at', null)->first();

            UserSubscription::findOrFail($subscription->id)->delete();
            
            return [
                "status" => "Success",
                "body" => "Subscription deleted successfully"
            ];

        }
        catch(QueryException $e){

            return [
                "status" => "Error",
                "body" => $e->getMessage()
            ];

        }

    }

    private function updateSubscriptionOnDelete($id){

        $user = UserData::findOrFail($id);
        $user -> type_of_user = 'free';
        $user -> save();

    }

    public function UpdateSubscription(Request $request, $id){
        
        try{
            
            $subscription = UserSubscription::where('id_users', $id)
            ->where('deleted_at', null)->first();

            $user = UserData::findOrFail($id);

            $subscription -> type_of_subscription = $request -> type_of_user;
            $subscription-> save();
            $user -> type_of_user = $request -> type_of_user;
            $user -> save();

            return [
                "status" => "Success",
                "body" => "User subscription updated successfully",
                "user_subscription" => $user -> type_of_user
            ];
            
        }
        catch (QueryException $e){

            return [
                "status" => "Error",
                "body" => $e->getMessage()
            ];
            
        }

    }

}
