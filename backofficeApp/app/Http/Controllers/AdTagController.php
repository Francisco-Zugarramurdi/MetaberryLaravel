<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use \Illuminate\Database\QueryException;
use App\Models\ad_tag;
class AdTagController extends Controller
{
    //
    public function create(Request $request){
        
        $validation = $this->validateRequest($request);

        if($validation !== "ok"){
            return $validation;
        }
        try{
            return $this->createAdTag($request);
        }
        catch (QueryException $e){

            return [
                "error" => 'Cannot create Tag',
                "trace" => $e -> getMessage()
            ];
        }
    }
    public function update(Request $request, $id){

        $validation = $this->validateRequest($request);

        if($validation !== "ok")
            return $validation;
        
        try{
            $this->updateAdTag($request, $id);
            return "ok";
        }
        catch (QueryException $e){
            return [
                "error" => 'Cannot update Tag',
                "trace" => $e -> getMessage()
            ];
        }
    }

    public function destroy($id){
        try{
            $tag = ad_tag::findOrFail($id);
            $tag->delete();
            return "Tag destroyed";
        }
        catch(QueryException $e){
            return [
                "error" => 'Cannot delete Tag',
                "trace" => $e -> getMessage()
            ];
        }
    }

    public function index(){
        return ad_tag::all();
    }

    private function updateAdTag($request, $id){
        $tag = ad_tag::findOrFail($id);

        $tag -> id_ad = $request -> id_ad;
        $tag -> tag = $request -> tag;

        $tag -> save();
    }

    private function validateCreationRequest(Request $request){

        $validator = Validator::make($request->all(),[

            'ad_id' => 'required',
            'tag' => 'required'
            
        ]);

        if($validator->fails())
            return $validator->errors()->toJson();

        if(ad_tag::withTrashed()->where('tag', $request -> post("tag")) -> exists())
            return 'Tag already exists';

        return 'ok';

    }

    private function validateRequest(Request $request){
        $validationRequest = $this->validateCreationRequest($request);

        if($validationRequest !== "ok")
            return $validationRequest;

        $createAdTag = $this->createAdTag($request);

        if($createAdTag !== "ok")
            return $createAdTag;
        return "ok";

    }

    private function createAdTag(Request $request){
        
        return ad_tag::create([

            'ad_id' => $request -> post("ad_id"),
            'tag' => $request -> post("tag") 

        ]);
    }
}

