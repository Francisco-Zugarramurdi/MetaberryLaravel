<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function Create(Request $request){
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
        try {
                return User::create([
                    'name' => $request -> post("name"),
                    'email' => $request -> post("email"),
                    'password' => Hash::make($request -> post("password"))
                ]);
            }
        catch (QueryException $e){
                return [
                    "error" => 'User ' . $request->post("name") . ' exists',
                    "trace" => $e -> getMessage()
                ];
            }
    }

    public function Authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|regex:/^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
            'password' => 'required|regex:^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
        ]);

        if ($validator->fails())
            return $validator->errors()->toJson();
        
                
        $target = User::where('email',$request->post("email"))->first();

        if(!$target)
            return [ "email" => "User does not exist"]; 
        
        $credentials = $request->only('email', 'password');
        if(!Auth::attempt($credentials))
            return ['status' => false];
        return ['status' => true];
        // $request = $request->makeVisible(['password']);
        //  return [
        //         "Status" => Hash::check($request -> post("password"),$target->password)
        // ]; 
    }
}
