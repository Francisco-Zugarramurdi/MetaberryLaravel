<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\League;
use App\Models\Country;
use App\Models\LeagueCountry;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class LeagueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok")
            return $validation;

        try{

            return $this->createLeague($request);

        }catch(QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot create league');

        }
    }

    private function validateCreationRequest(Request $request){

        $validation = Validator::make($request->all(),[
            'name'=> 'required',
            'details'=> 'required'
        ]);

        if($validation->fails())
            return $validation->errors()->toJson();

        return 'ok';
    }

    public function createLeague(Request $request){
        
        $image = $this->saveImage($request, 'default_img_do_not_delete.jpg');

        $league = League::create([
            'name'=> $request->name,
            'details'=> $request->details,
            'photo'=> $image
        ]);

        $this->joinTable($request, $league->id);

        return redirect('/league');

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

    private function joinTable(Request $request, $id){

        $country = Country::where('id',$request->countryName)->first();
        LeagueCountry::create([
            'id_countries' => $country->id,
            'id_leagues' => $id
        ]);

    }

    public function index(Request $request){
    
        $league = League::join('leagues_countries', 'leagues_countries.id_leagues', 'leagues.id')
        ->join('countries','countries.id','leagues_countries.id_countries')
        ->select('leagues.id as id','leagues.name as name','leagues.details as details','leagues.photo as photo','countries.name as countryName', 'countries.id as countryId')
        ->get();

        $country = Country::all();

        return view('league')->with('leagues', $league)->with('countries', $country);
    }

    public function update(Request $request, $id){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok")
            return $validation;
        
        try{
                
            $this->updateLeagueData($request, $id);
            $this->updateLeagueCountryData($request, $id);

            return redirect('/league');
            
        }
        catch (QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot update league');
            
        }

    }

    private function updateLeagueData(Request $request, $id){

        $league = League::findOrFail($id);
        $currentImage = $league -> photo; 

        $image = $this->updateImage($request, $currentImage, $id);

        $league -> name = $request -> name;
        $league -> details = $request-> details;
        $league -> photo = $image;
        $league-> save();

    }

    private function updateImage(Request $request, $currentImage, $id){

        if($request->hasFile('image'))
            $this->deleteImage($id);

        return $this->saveImage($request, $currentImage);

    }
    
    private function deleteImage($id){

        $league = League::findOrFail($id);
        $currentImage = $league -> photo; 

        if($currentImage != 'default_img_do_not_delete.jpg'){

            $destinationPath = public_path('\img\public_images');
            $imagePath = $destinationPath . '/' . $currentImage;
        
            File::delete($imagePath);
    
        }

    }

    private function updateLeagueCountryData(Request $request, $id){

        $country = DB::table('leagues_countries')
        ->where('id_leagues', $id)
        ->update(['id_countries' => $request->countryName]);

    }

    public function destroy($id){

        $validation = $this->validateDestroy($id);

        if($validation !== "ok"){
            return view('error')->with('errors', $validation);
        }
        try{
            return $this->delete($id);
        }
        catch(QueryException $e){
            return $e;
            return view('error')->with('errorData',$e)->with('errors', 'Cannot destroy league');
        }

    }

    private function validateDestroy($id){

        if(DB::table('leagues_events')->where('id_leagues',$id)->exists())
            return 'Cannot destroy league because there is related to an event';
        return "ok";
    }

    private function delete($id){

        DB::table('leagues_countries')
        ->where('id_leagues', $id)
        ->update(['leagues_countries.deleted_at'=>Carbon::now()]);

        $this->deleteImage($id);
        League::findOrFail($id)->delete();

        return redirect('/league');

    }
}

