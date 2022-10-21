<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Event;
use App\Models\Team;
use App\Models\LeagueCountry;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\QueryException;

class CountryController extends Controller
{
    
    public function create(Request $request){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok"){
            return $validation;
        }
        try {

            if(Country::where('name', $request -> name) -> exists())
                return view('error')->with('errorData',$e)->with('errors', 'Country already exists');

            return $this->createCountry($request);
        }
        catch (QueryException $e){

            return $e;

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

    private function createCountry(Request $request){

        Country::create([
            'name'=> $request->name,
            'photo'=> $request->photo
        ]);

        return redirect('/country');

    }

    public function index(Request $request){

        $countries = Country::all();

        return view('country')->with('countries', $countries);

    }

    public function update(Request $request, $id){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok")
            return $validation;
        
        try{
                
            $this->updateCountryData($request, $id);

            return redirect('/country');
            
        }
        catch (QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot update country');
            
        }
    }

    private function updateCountryData(Request $request, $id){

        $country= Country::findOrFail($id);
        $country -> name = $request -> name;
        $country -> photo = $request -> photo;
        $country-> save();

    }

    public function destroy($id){

        $validation = $this->validateDestroy($id);

        if($validation !== "ok"){
            return view('error')->with('errors', $validation);
        }
        try{
            Country::findOrFail($id)->delete();
            return redirect('/country');
        }
        catch(QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot destroy country');

        }

    }

    private function validateDestroy($id){

        $events = Event::where('id_countries',$id)->exists();
        $teams = Team::where('id_countries',$id)->exists();
        $league = LeagueCountry::where('id_countries', $id)->exists();

        if($events || $teams || $league)
            return 'Cannot destroy country, because it is related to an entity';
        return 'ok';
    }

}
