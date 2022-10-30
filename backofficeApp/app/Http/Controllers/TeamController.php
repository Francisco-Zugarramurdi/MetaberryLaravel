<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Sport;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class TeamController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){

        $validation = $this->validateRequest($request);

        if($validation !== "ok"){
            return $validation;
        }
        if(Team::where('name', $request -> post("name")) -> exists())
            return view('error')->with('errors', 'Team already exists');

        try {
            return $this->createTeam($request);
        }
        catch (QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot create team');

        }
    }

    private function createTeam(Request $request){

        $image = $this->saveImage($request, 'default_img_do_not_delete.jpg');

        Team::create([
            'name' => $request -> post("name"),
            'type_teams' => $request -> post("typeTeam"),
            'photo' => $image,
            'id_sports' => Sport::where('name', $request -> post("sportName"))->first()->id,
            'id_countries' => Country::where('name', $request -> post("countryName"))->first()->id
        ]);

        return redirect('/team');
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

    public function index(){
        $teams = Team::join('sports','sports.id','teams.id_sports')
        ->join('countries', 'countries.id', 'teams.id_countries')
        ->select("teams.id as id", "teams.name as name", "teams.photo as photo","teams.type_teams as typeTeam", "sports.name as sportName", "countries.name as countryName")
        ->orderBy('name')
        ->paginate(10);

        $country = Country::all();
        $sport = Sport::all();

        return view('teams')->with('teams',$teams)->with('countries', $country)->with('sports', $sport);
    }

    public function getTeams(){
        
        return Team::all();
    }

    public function update(Request $request, $id){

        $validation = $this->validateRequest($request);

        if($validation !== "ok")
            return $validation;
        try {
            $this->updateTeam($request, $id);
            return redirect('/team');
        }
        catch (QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot update team');
        }
        
    }

    private function validateRequest($request){

        $validator = Validator::make($request->all(),[

            'name' => 'required',
            'typeTeam' => 'required',
            'sportName' => 'required',
            'countryName' => 'required'

        ]);

        if($validator->fails())
            return $validator->errors()->toJson();
        
        return 'ok';
    }

    private function updateTeam(Request $request, $id){

        $team = Team::findOrFail($id);
        $currentImage = $team -> photo; 

        $image = $this->updateImage($request, $currentImage, $id);
        
        $team -> name = $request->name;
        $team -> photo = $image;
        $team -> type_teams = $request -> typeTeam;
        $team -> id_sports = Sport::where('name', $request->sportName)->first()->id;
        $team -> id_countries = Country::where('name', $request -> countryName)->first()->id;
        $team -> save();
        return redirect('/team');
    }

    private function updateImage(Request $request, $currentImage, $id){

        if($request->hasFile('image'))
            $this->deleteImage($id);

        return $this->saveImage($request, $currentImage);

    }
    
    private function deleteImage($id){

        $team = Team::findOrFail($id);
        $currentImage = $team -> photo; 

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
            return $this->delete($id);
        }
        catch(QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot delete team');
        }
    }

    private function validateDestroy($id){

        if(DB::table('events_teams')->where('id_teams',$id)->where('deleted_at', null)->exists()){
            return 'Cannot destroy team because it is related to an event';
        }
        return 'ok';

    }

    private function delete($id){

        $this->deletePlayers($id);
        $this->deleteExtra($id);
        $this->deleteImage($id);
        Team::findOrFail($id)->delete();

        return redirect('/team');

    }

    private function deletePlayers($id){

        DB::table('players_teams')
        ->join('players','players.id','players_teams.id_players')
        ->where('players_teams.id_teams',$id)
        ->update(['players_teams.deleted_at'=>Carbon::now()]);

    }

    private function deleteExtra($id){

        DB::table('extra_compose')
        ->join('extras','extras.id','extra_compose.id_extra')
        ->where('extra_compose.id_teams',$id)
        ->update(['extra_compose.deleted_at'=>Carbon::now()]);

    }

}
