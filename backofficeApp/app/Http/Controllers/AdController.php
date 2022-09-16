<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ad;
use App\Models\ad_tag;



class AdController extends Controller
{
    public function create(Request $request){
        $this->validate($request);

        if($validation !== "ok"){
            return $validation;
        }
        try{
            return $this->createAd($request);
        }catch(QueryException $e){

        }
    }
    public function index(){
        return $AdWithTags = Ad::join("ad_tags","ad_tags.ad_id", "=", "ads.id")
        ->select("*")
        ->get();
    }
    public function update(Request $request){
        $this->validate($request);

        if($validation !== "ok"){
            return $validation;
        }

        $this->updateAd($request, $id);
        return "data updated";
    }
    public function destroy(Request $request){
        try{
            $ad = ad::findOrFail($id);
            $ad -> delete();
            return "User destroyed";
        }catch(QueryException $e){
            return [
                "error" => 'Cannot delete user',
                "trace" => $e -> getMessage()
            ];
        }
    }
    
    private function validate(Request $request){
        $validator = Validator::make($request,
        [
            'url' => 'required|regex:/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)',
            'image' => 'required',
            'views_hired' => 'required',
            'size' => 'required',
            'tag' => 'required'  
        ]);
        if($validator->fails())
            return $validator->errors()->toJson();
        return 'ok';

        if(User::withTrashed()->where('tag', $request -> post("tag")) -> exists())
            return 'Tag already exists';

        if(User::withTrashed()->where('image', $request -> post("image")) -> exists())
            return 'image already exists';
        
        return 'ok';
    }

    private function createAd(Request $request){
        $ad = Ad::create([
            'image' => $request -> post("image"),
            'url' => $request -> post("url"),
            'views_hired' => $request -> post("views_hired"),
            'size' => $request -> post("size"),
            'view_counter' => 0
        ]);
        User::create([
            'id_ad' => $ad ->id,
            'tag' => $request -> post("tag"),
        ]);
        return "Ad created";
    }
    private function updateAd(Request $request){
        $ad = ad::findOrFail($id);
        'image' -> $request -> post("image");
        'url' -> $request -> post("url");
        'views_hired' -> $request -> post("views_hired");
        'size' -> $request -> post("size");
    }
}
