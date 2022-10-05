<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Extra;
use App\Models\ExtraCompose;
use App\Models\Team;
use \Illuminate\Database\QueryException;

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
            return [ 
                "error" => 'Can not create Extra',
                "trace" => $e -> getMessage()
            ];
        }
    }
    private function validateCreationRequest(Request $request){
        $validation = Validator::make($request->all(),[
            'name'=> 'required',
            'surname'=> 'required',
            'rol'=> 'required',
            'photo'=> [
                'required',
                'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            ]
        ]);
        if($validation->fails())
            return $validation->errors()->toJson();
        if(!Team::where('name','=',$request->teamName)->exists())
            return "Error, team does not exist";
        return 'ok';

    }
    private function createExtra(Request $request){
        $extra = Extra::create([
            'name'=> $request->name,
            'surname'=> $request->surname,
            'rol'=> $request->rol,
            'photo'=> $request->photo
        ]);
        if($request->teamName != null)
            $this->joinTeam($request,$extra->id);

        return redirect('/extra');

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
        $extras = Extra::rightJoin('extra_compose','extra_compose.id_extra','extras.id');
        return view('extras')->with('extras',Extra::all());
        
    }
    public function destroy($id){
        try{
            Extra::findOrFail($id)->delete();
            return redirect('/extra');
        }
        catch(QueryException $e){
            return [
                "error" => 'Can not delete Extra',
                "trace" => $e -> getMessage()
            ];
        }
        
    }
}
