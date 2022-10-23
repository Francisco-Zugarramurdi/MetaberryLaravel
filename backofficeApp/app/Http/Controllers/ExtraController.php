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
    public function create(Request $request){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok")
            return $validation;
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
            'image' => 'required|image',
        ]);
        if($validation->fails())
            return $validation->errors()->toJson();
        return 'ok';

    }
    private function createExtra(Request $request){

        $image = $this->saveImage($request);

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

    private function saveImage(Request $request){

        if($request->hasFile('image')){

            $destinationPath = public_path('/img/public_images');
            $image = $request->file('image');
            $name = 'profile_img' . time();
            $imagePath = $name . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imagePath);

            return $imagePath;

        }

    }

    private function deleteImage($id){

        $user = Extra::findOrFail($id);
        $image = $user -> photo; 

        $destinationPath = public_path('/img/public_images');

        $imagePath = $destinationPath . '/' . $image;

        File::delete($imagePath);

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
    public function index(){
        $extras = Extra::leftJoin('extra_compose','extra_compose.id_extra','extras.id')
        ->leftJoin('teams','extra_compose.id_teams','teams.id')
        ->select('extras.id as id','extras.name as name','extras.surname as surname','extras.photo as photo','extras.rol as rol','teams.name as teamName','extra_compose.contract_start as contractStart','extra_compose.contract_end as contractEnd')
        ->get();

        $team = Team::all();
        return view('extras')->with('extras',$extras)->with('teams', $team);
        
    }
    
    public function destroy($id){
        try{
            $this->deleteImage($id);
            Extra::findOrFail($id)->delete();
            return redirect('/extra');
        }
        catch(QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot destroy extra');
        }
        
    }

    public function update(Request $request, $id){
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

        $this->deleteImage($id);
        $image = $this->saveImage($request);

        $extra = Extra::findOrFail($id);
        $extra->name = $request->name;
        $extra->surname = $request->surname;
        $extra->photo = $image;
        $extra->rol = $request->rol;
        $extra->save();
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
}
