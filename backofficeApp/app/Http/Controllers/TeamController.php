<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function create(Request $request){
        $this->validateCreationRequest();
        if($validation !== "ok"){
            return $validation;
        }
        try {
            return $this->createTeam($request);
        }
        catch (QueryException $e){

            return [
                "error" => 'Cannot create user',
                "trace" => $e -> getMessage()
            ];

        }
    }

    private function validateCreationRequest(){
        $validator = Validator::make($request->all(),[

            'name' => 'required',
            'photo' => 'required',
            'typeTeam' => 'required',
            'sport' => 'required',
            'country' => 'required'

        ]);

        if($validator->fails())
            return $validator->errors()->toJson();
        return 'ok';
    }


    public function index(){

    }
    public function update(Request $request, $id){

    }
    public function destroy($id){

    }

}
