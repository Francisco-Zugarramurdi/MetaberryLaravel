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

    private function validateCreationRequest($request){

        $validator = Validator::make($request->all(),[

            'nickname' => 'required',
            'email' => 'required|regex:/^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
            'password' => 'required|regex:/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^/',
            'credit_card' => 'required|regex: /^(4[0-9]{12}(?:[0-9]{3})?)|((?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}))|((5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12})))$/',
            'photo' => 'required|regex:/[(http(s)?):\/\/(www\.)?a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/ig',
            'points' => 'required',
            'type_of_user' => 'required',
            'total_points' => 'required'

        ]);

        if($validator->fails())
            return $validator->errors()->toJson();
        return 'ok';

    }

    private function createUser($request){

        $user = users_data::create([

            'name' => $request -> post("nickname"),
            'credit_card' => $request -> post("credit_card"),
            'photo' => $request -> post("photo"),
            'points' => $request -> post("points"),
            'type_of_user' => $request -> post("type_of_user"),
            'total_points' => $request -> post("total_points")

        ]);
        
        return User::create([
            'id' => $user ->id,
            'name' => $request -> post("nickname"),
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

}
