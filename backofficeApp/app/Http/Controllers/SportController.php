<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\QueryException;

class SportController extends Controller
{
    
    public function create(Request $request){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok"){
            return $validation;
        }
        try {
            return $this->createSport($request);
        }
        catch (QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot create sport');

        }

    }
    
    private function validateCreationRequest(Request $request){

        $validation = Validator::make($request->all(),[
            'name'=> 'required',
            'photo'=> [
                'required',
                'regex:/(?i)^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            ]
        ]);

        if($validation->fails())
            return $validation->errors()->toJson();
        return 'ok';
        
    }

    private function createSport(Request $request){

        Sport::create([
            'name'=> $request->name,
            'photo'=> $request->photo
        ]);
        
        Tag::create([
            'tag' =>$request->name
        ]);
        
        return redirect('/sport');

    }

    public function index(Request $request){

        $sports = Sport::all();

        return view('sport')->with('sports', $sports);

    }

    public function update(Request $request, $id){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok")
            return $validation;
        
        try{
                
            $this->updateSportData($request, $id);

            return redirect('/sport');
            
        }
        catch (QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot update sport');
            
        }
    }

    private function updateSportData(Request $request, $id){

        $sport= Sport::findOrFail($id);
        $sport -> name = $request -> name;
        $sport -> photo = $request -> photo;
        $sport-> save();

    }

    public function destroy($id){

        try{
            Sport::findOrFail($id)->delete();
            return redirect('/sport');
        }
        catch(QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot destroy sport');
        }

    }

}
