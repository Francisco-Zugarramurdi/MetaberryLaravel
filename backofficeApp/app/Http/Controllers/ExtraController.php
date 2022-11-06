<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Extra;
use App\Models\ExtraCompose;
use App\Models\Team;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ExtraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Create(Request $request){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok")
            return view('error')->with('errors', $validation);
        try{
            return $this->createExtra($request);
        
        }
        catch(QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot create extra');
        }
    }
    private function validateCreationRequest(Request $request){
        $validation = Validator::make($request->all(),[
            'name'=> 'required',
            'surname'=> 'required',
            'rol'=> 'required',
            'contractStart' => 'date',
            'contractEnd' => 'after:contractStart'
        ]);
        if($validation->fails())
            return $validation->errors()->toJson();
        return 'ok';

    }
    private function createExtra(Request $request){

        $image = $this->saveImage($request, 'default_img_do_not_delete.jpg');

        $extra = Extra::create([
            'name'=> $request->name,
            'surname'=> $request->surname,
            'rol'=> $request->rol,
            'photo'=> $image
        ]);
        if($request->teamName != null)
            $this->joinTeam($request,$extra->id);

        return redirect('/extra');

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

    private function joinTeam(Request $request,$id){
        $team = Team::where('name',$request->teamName)->first();
        ExtraCompose::create([
            'id_teams' => $team->id,
            'id_extra' => $id,
            'contract_start' => $request->contractStart,
            'contract_end' => $request->contractEnd
        ]);
    }
    public function Index(){
        $extras = Extra::leftJoin('extra_compose','extra_compose.id_extra','extras.id')
        ->leftJoin('teams','extra_compose.id_teams','teams.id')
        ->select('extras.id as id','extras.name as name','extras.surname as surname','extras.photo as photo','extras.rol as rol','teams.name as teamName','extra_compose.contract_start as contractStart','extra_compose.contract_end as contractEnd')
        ->orderBy('name')
        ->paginate(10);

        $team = Team::all();
        return view('extras')->with('extras',$extras)->with('teams', $team);
        
    }
    
    public function Destroy($id){
        try{
            $this->deleteImage($id);
            Extra::findOrFail($id)->delete();
            return redirect('/extra');
        }
        catch(QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot destroy extra');
        }
        
    }

    public function Update(Request $request, $id){
        $validation = $this->validateCreationRequest($request);

        if($validation !== 'ok')
            return $validation;
        
        try{
            $this->updateExtra($request,$id);
            $this->updateTeam($request,$id);
            return redirect('/extra');
        }
        catch (QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot update extra');
        }
    }

    private function updateExtra(Request $request,$id){

        $extra = Extra::findOrFail($id);
        $currentImage = $extra -> photo; 

        $image = $this->updateImage($request, $currentImage, $id);

        $extra->name = $request->name;
        $extra->surname = $request->surname;
        $extra->photo = $image;
        $extra->rol = $request->rol;
        $extra->save();
    }

    private function updateImage(Request $request, $currentImage, $id){

        if($request->hasFile('image'))
            $this->deleteImage($id);

        return $this->saveImage($request, $currentImage);

    }
    
    private function deleteImage($id){

        $extra = Extra::findOrFail($id);
        $currentImage = $extra -> photo; 

        if($currentImage != 'default_img_do_not_delete.jpg'){

            $destinationPath = public_path('\img\public_images');
            $imagePath = $destinationPath . '/' . $currentImage;
        
            File::delete($imagePath);
    
        }

    }

    private function updateTeam(Request $request,$id){
        $team = Team::where('name', $request->teamName)->first()->id;
        $teamName = DB::table('extra_compose')
        ->where('id_extra', $id)
        ->update([
            'contract_start'=>$request->contractStart,
            'id_teams'=> $team,
            'contract_end'=>$request->contractEnd
        ]);
    }
    public function IndexExtrasByEvent(Request $request){

        return DB::table('events')
        ->join('events_teams','events_teams.id_events','events.id')
        ->join('extra_compose','extra_compose.id_teams','events_teams.id_teams')
        ->join('extras','extras.id','extra_compose.id_extra')
        ->select('extras.id as id','extras.name as name','extras.surname as surname','events_teams.id_events as eventId')
        ->get()
        ->where('eventId',$request->id);
        
     
       
        
    }



}
