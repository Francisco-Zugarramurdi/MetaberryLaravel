<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Event;
use App\Models\Team;
use App\Models\LeagueCountry;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create(Request $request){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok"){
            return $validation;
        }
        try {

            if(Country::where('name', $request -> name) -> exists())
                return view('error')->with('errors', 'Country already exists');

            return $this->createCountry($request);
        }
        catch (QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot create country');

        }

    }

    private function validateCreationRequest(Request $request){

        $validation = Validator::make($request->all(),[
            'name'=> 'required'
        ]);

        if($validation->fails())
            return $validation->errors()->toJson();
        return 'ok';
        
    }

    private function createCountry(Request $request){

        $image = $this->saveImage($request, 'default_img_do_not_delete.jpg');

        Country::create([
            'name'=> $request->name,
            'photo'=> $image
        ]);

        return redirect('/country');

    }

    private function saveImage(Request $request, $defaultImage){

        if($request->hasFile('image')){
            
            $destinationPath = public_path('/img/public_images');
            $image = $request->file('image');
            $name = 'profile_img' . time();
            $imagePath = $name . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imagePath);

            return $imagePath;

        }
        return $defaultImage;

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

        $country = Country::findOrFail($id);
        $currentImage = $country -> photo; 

        $image = $this->updateImage($request, $currentImage, $id);

        $country -> name = $request -> name;
        $country -> photo = $image;
        $country-> save();

    }

    private function updateImage(Request $request, $currentImage, $id){

        if($request->hasFile('image'))
            $this->deleteImage($id);

        return $this->saveImage($request, $currentImage);

    }
    
    private function deleteImage($id){

        $country = Country::findOrFail($id);
        $currentImage = $country -> photo; 

        if($currentImage != 'default_img_do_not_delete.jpg'){

            $destinationPath = public_path('\img\public_images');
            $imagePath = $destinationPath . '/' . $currentImage;
        
            File::delete($imagePath);
    
        }

    }

    public function destroy($id){

        $validation = $this->validateDestroy($id);

        if($validation !== "ok"){
            return view('error')->with('errors', $validation);
        }
        try{

            $this->deleteImage($id);
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
