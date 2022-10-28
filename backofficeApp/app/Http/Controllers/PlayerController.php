<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Player;
use App\Models\PlayerTeam;
use App\Models\Team;
use App\Models\Country;
use App\Models\Sport;
use App\Models\Sanction;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class PlayerController extends Controller
{
    public function create(Request $request){
        $validation = $this->validateCreationRequest($request);
        if($validation !== "ok")
            return $validation;
        try{
            return $this->createPlayer($request);
        }catch(QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot create player');

        }
    }

    private function validateCreationRequest(Request $request){
        $validation = Validator::make($request->all(),[
            'name'=> 'required',
            'surname'=> 'required'
        ]);
        if($validation->fails())
            return $validation->errors()->toJson();
        if(!Team::find($request->team)->exists() && $request->team != null)
            return view('error')->with('errorData',$e)->with('errors', 'Team does not exist');
        if($request->individual != null && $request->sport == null){
            return view('error')->with('errorData',$e)->with('error','player must have an sport');
        }
        return 'ok';

    }

    private function createPlayer(Request $request){

        $image = $this->saveImage($request, 'default_img_do_not_delete.jpg');

        $player = Player::create([
            'name'=> $request->name,
            'surname'=> $request->surname,
            'photo'=> $image
        ]);
        if($request->team != null || $request->individual != null)
            $this->joinTeam($request,$player->id,$image);
        
        return redirect('/player');

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

    private function joinTeam(Request $request,$id,$image){
        if($request->team != null){
            PlayerTeam::create([
                'id_teams' => $request->team,
                'id_players' => $id,
                'contract_end' =>$request->contractEnd,
                'contract_start' => $request->contractStart,
                'status' => $request->status
    
            ]);
        }
        if($request->individual != null){
            $team = Team::create([
                'name' => $request->name,
                'type_teams' => "Individual",
                'photo' => $image,
                'id_sports' => $request->sport,
                'id_countries' => $request->country
            ]);
            PlayerTeam::create([
                'id_teams' => $team->id,
                'id_players' => $id,
                'contract_end' =>$request->contractEnd,
                'contract_start' => $request->contractStart,
                'status' => $request->status
    
            ]);

        }

    }

    public function index(){

        $players = Player::join('players_teams','players_teams.id_players','players.id')
        ->join('teams','players_teams.id_teams','teams.id')
        ->select('players.id as id','players.name as name','players.surname as surname','players.photo as photo','teams.name as teamName','players_teams.contract_start as contractStart','players_teams.contract_end as contractEnd','players_teams.status as status')
        ->get();

        return view('players')->with('players',$players)->with('teams',Team::all())->with('sports',Sport::all())->with('countries',Country::all());
        
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
            return view('error')->with('errorData', $e)->with('errors', 'Cannot destroy player');
        }
        
    }

    private function delete($id){

        $this->deleteFromTeam($id);
        $this->deleteSanction($id);
        $this->deleteImage($id);

        Player::findOrFail($id)->delete();

        return redirect('/player');

    }

    private function deleteFromTeam($id){
    
        DB::table('players_teams')
        ->join('teams','teams.id','players_teams.id_teams')
        ->where('players_teams.id_players',$id)
        ->where('teams.type_teams','Individual')
        ->update(['teams.deleted_at'=>Carbon::now()]);

    }

    private function deleteSanction($id){

        $sanctions = DB::table('sanctions_players')->where('id_players',$id)->get();

        foreach($sanctions as $sanction){
            
            $target = Sanction::find($sanction->id_sancion);
            if($target) $target->delete();

        } 

        DB::table('sanctions_players')->where('id_players',$id)->update(['deleted_at'=>Carbon::now()]);

    }

    private function validateDestroy($id){

        if(DB::table('results_points')->where('id_players',$id)->where('deleted_at', null)->exists()){
            return 'Cannot destroy player because it is related to a result';
        }
        return 'ok';

    }

    public function update(Request $request, $id){

        $validation = $this->validateCreationRequest($request);
        if($validation !== "ok")
            return $validation;
        try{
            $this->updatePlayer($request,$id);    
            $this->updateTeam($request,$id);
           
            return redirect('/player');
            
        }
        catch (QueryException $e){
            return view('error')->with('errorData',$e)->with('errors','Cannot update player');
        }

    }
    private function updatePlayer($request,$id){

        $player = Player::findOrFail($id);
        $currentImage = $player -> photo;

        $image = $this->saveImage($request, $currentImage, $id);

        $player-> name = $request->name;
        $player-> surname = $request->surname;
        $player-> photo = $image;
        $player->save();
    }

    private function updateImage(Request $request, $currentImage, $id){

        if($request->hasFile('image'))
            $this->deleteImage($id);

        return $this->saveImage($request, $currentImage);

    }
    
    private function deleteImage($id){

        $player = Player::findOrFail($id);
        $currentImage = $player -> photo; 

        if($currentImage != 'default_img_do_not_delete.jpg'){

            $destinationPath = public_path('\img\public_images');
            $imagePath = $destinationPath . '/' . $currentImage;
        
            File::delete($imagePath);
    
        }

    }

    private function updateTeam($request,$id){
        $team = Team::where('name',$request->team)->first();
        $playerTeam = DB::table('players_teams')
        ->where('id_teams',$team->id)
        ->where('id_players',$id)
        ->update([
            'contract_start' => $request->contractStart,
            'contract_end' => $request->contractEnd,
            'status' => $request->status ]);
    }
    public function addTeam(Request $request){
        $team = Team::where('name',$request->team)->first();
        if($team->exists()){
             DB::table('players_teams')->insert([
                'id_teams'=>$team->id,
                'id_players'=>$request->playerId,
                'contract_start'=>$request->contractStart,
                'contract_end' =>$request->contractEnd,
                'status' =>$request->status
            ]);
        }
        return redirect('/player');
    }

    public function indexPlayersById(Request $request){
        return Player::leftJoin('players_teams','players_teams.id_players','players.id')
        ->leftJoin('teams','players_teams.id_teams','teams.id')
        ->select('players.id as id','players.name as name','players.surname as surname','players.photo as photo','teams.name as teamName','teams.id as teamId','players_teams.contract_start as contractStart','players_teams.contract_end as contractEnd','players_teams.status as status')
        ->get()
        ->where('teamId', $request->teamId);
    }
    public function indexPlayersByEvent(Request $request){
        $players = DB::table('events')
        ->join('events_teams','events_teams.id_events','events.id')
        ->join('players_teams','players_teams.id_players','events_teams.id_players')
        ->join('players','players.id','players_teams.id_players')
        ->select('players.id as id','players.name as name','players.surname as surname','events_teams.id_events as eventId')
        ->get()
        ->where('eventId',$request->id);
        return $players;
    }
}
