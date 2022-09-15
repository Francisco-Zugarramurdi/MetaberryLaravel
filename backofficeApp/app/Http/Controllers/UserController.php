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

        $validationRequest = $this->validateRequest($request);

        if($validationRequest !== "ok")
            return $validationRequest;

        $validationRegexRequest = $this->validateRegexRequest($request);

        if($validationRegexRequest !== "ok")
            return $validationRegexRequest;

        try {
            return $this->createUser($request);
        }
        catch (QueryException $e){
            return $this->handleCreationErrors($e,$request->post("email"));
        }
        
    }

    public function indexByEmail($email){

        $user = User::where('email', $email)->first();

        if ($user) 
            return $user;
        return 'error: User ' . $email . ' does not exist';

    }

    public function index(){

        return User::all();

    }

    public function edit($id){

        $users = User::all();
        
        $user = User::findOrFail($id);

    }

    public function update($request, $id){

        $user = User::findOrFail($id);

    }

    private function validateRegexRequest($request){

        $validator = Validator::make($request->all(),
        
        [

            'email' => 'regex:/^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
            'password' => 'regex:^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
            'credit_card' => 'regex:/^4[0-9]{12}(?:[0-9]{3})?$/',
            'photo' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            
        ]);

        if($validator->fails())
            return $validator->errors()->toJson();
        return 'ok';

    }

    private function validateRequest($request){

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
        return 'ok';

    }

    // private function validateCreationRequest($request){

        // $validator = Validator::make($request->all(),[

        //     'name' => 'required',
        //     'email' => 'required|regex:/^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
        //     'password' => 'required|regex:^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
        //     'credit_card' => '',
        //     'photo' => 'required',
        //     'points' => 'required',
        //     'type_of_user' => 'required',
        //     'total_points' => 'required'

        // ]);

    //     if($validator->fails())
    //         return $validator->errors()->toJson();
    //     return 'ok';

    // }

    private function createUser($request){

        $user = users_data::create([

            'name' => $request -> post("name"),
            'credit_card' => $request -> post("credit_card"),
            'photo' => $request -> post("photo"),
            'points' => $request -> post("points"),
            'type_of_user' => $request -> post("type_of_user"),
            'total_points' => $request -> post("total_points")

        ]);
        
        return User::create([

            'id' => $user ->id,
            'name' => $request -> post("name"),
            'email' => $request -> post("email"),
            'password' => Hash::make($request -> post("password"))

        ]);
    }

    private function handleCreationErrors($e,$email){
        return [
            "error" => 'User ' . $email . ' already exists',
            "trace" => $e -> getMessage()
        ];
    }

    

}
