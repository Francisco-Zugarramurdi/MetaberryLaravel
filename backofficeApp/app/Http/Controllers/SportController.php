<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\QueryException;

class SportController extends Controller
{
 
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function Create(Request $request){

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
            'icon'=> 'required'
        ]);

        if($validation->fails())
            return $validation->errors()->toJson();
        return 'ok';
        
    }

    private function createSport(Request $request){

        Sport::create([
            'name'=> $request->name,
            'icon'=> $request->icon
        ]);
        
        Tag::create([
            'tag' =>$request->name
        ]);
        
        return redirect('/sport');

    }

    public function Index(Request $request){

        $sports = Sport::orderBy('name')->paginate(10);

        return view('sport')->with('sports', $sports);

    }

    public function Update(Request $request, $id){

        $validation = $this->validateUpdateRequest($request);

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

        $sport = Sport::findOrFail($id);
        $sport -> name = $request -> name;
        $sport -> icon = $sport -> icon;
        $sport-> save();

    }

    private function validateUpdateRequest(Request $request){

        $validation = Validator::make($request->all(),[
            'name'=> 'required'
        ]);

        if($validation->fails())
            return $validation->errors()->toJson();
        return 'ok';
        
    }

    public function Destroy($id){

        $validation = $this->validateDestroy($id);

        if($validation !== "ok"){
            return view('error')->with('errors', $validation);
        }
        try{
            Sport::findOrFail($id)->delete();
            return redirect('/sport');
        }
        catch(QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot destroy sport');
        }

    }

    private function validateDestroy($id){

        $events = Event::where('id_sports',$id)->exists();
        $teams = Team::where('id_sports',$id)->exists();

        if($events || $teams)
            return 'Cannot destroy country, because it is related to an entity';
        return 'ok';
        
    }

}
