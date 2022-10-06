<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Referee;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\QueryException;

class RefereeController extends Controller
{
    public function create(Request $request){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok"){
            return $validation;
        }
        try {
            return $this->createReferee($request);
        }
        catch (QueryException $e){

            return [
                "error" => 'Cannot create referee',
                "trace" => $e -> getMessage()
            ];

        }

    }

    private function validateCreationRequest(Request $request){

        $validation = Validator::make($request->all(),[
            'name'=> 'required',
            'surname'=> 'required',
            'photo'=> [
                'required',
                'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            ]
        ]);

        if($validation->fails())
            return $validation->errors()->toJson();
        return 'ok';
        
    }

    private function createReferee(Request $request){

        Referee::create([
            'name'=> $request->name,
            'surname'=> $request->surname,
            'photo' => $request->photo
        ]); 

        return redirect('/referee');

    }

    public function index(Request $request){

        $referee = Referee::all();

        return view('referee')->with('referees', $referee);

    }

    public function update(Request $request, $id){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok")
            return $validation;
        
        try{
                
            $this->updateRefereeData($request, $id);

            return redirect('/referee');
            
        }
        catch (QueryException $e){

            return [
                "error" => 'Cannot update referee',
                "trace" => $e -> getMessage()
            ];
            
        }
    }

    private function updateRefereeData(Request $request, $id){

        $referee= Referee::findOrFail($id);
        $referee -> name = $request -> name;
        $referee -> surname = $request -> surname;
        $referee -> photo = $request -> photo;
        $referee-> save();

    }

    public function destroy($id){

        try{
            Referee::findOrFail($id)->delete();
            return redirect('/referee');
        }
        catch(QueryException $e){
            return [
                "error" => 'Cannot delete referee',
                "trace" => $e -> getMessage()
            ];
        }

    }

}
