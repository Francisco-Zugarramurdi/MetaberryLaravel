<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ad;
use App\Models\ad_tag;
use Illuminate\Support\Facades\DB;
use \Illuminate\Database\QueryException;



class AdController extends Controller
{
    public function create(Request $request){
        $validation = $this->validateRequestCreate($request);

        if($validation !== "ok"){
            return $validation;
        }
        try{
            return $this->createAd($request);
        }catch(QueryException $e){

        }
    }

    public function index(){
        $ads = ad::rightJoin("ad_tags","ad_tags.ad_id", "=", "ads.id")
        ->select("*")
        ->get();
        return view('ads')->with('ads',$ads);
    }

    public function update(Request $request, $id){

        try{
            $this->updateAd($request, $id);
            return "data updated";
        }catch(QueryException $e){

            return [
                "error" => 'Cannot update ad',
                "trace" => $e -> getMessage()
            ];
            
        }
        
    }

    public function destroy($id){
        try{
            $ad = ad::findOrFail($id);
            $ad -> delete();
            return "Ad destroyed";
        }catch(QueryException $e){
            return [
                "error" => 'Cannot delete ad',
                "trace" => $e -> getMessage()
            ];
        }
    }
    
    private function validateRequestCreate(Request $request){
        $validator = Validator::make($request->all(),[
            'size' => 'required',
            'tag' => 'required',
            'url' => 'required',
            'image' => 'required',
            'views_hired' => 'required'
        ]);
        if ($validator->fails())
            return $validator->errors()->toJson();

        if(ad::withTrashed()->where('image', $request -> post("image")) -> exists())
            return 'image already exists';
        
        return 'ok';
    }

    private function createAd(Request $request){
        $ad = ad::create([
            'image' => $request -> post("image"),
            'url' => $request -> post("url"),
            'views_hired' => $request -> post("views_hired"),
            'size' => $request -> post("size"),
            'view_counter' => 0
        ]);
        ad_tag::create([
            'id_ad' => $ad ->id,
            'tag' => $request -> post("tag"),
        ]);
        return "Ad created";
    }

    private function updateAd(Request $request, $id){
        $ad = ad::findOrFail($id);
        $ad ->image = $request -> image;
        $ad ->url = $request -> url;
        $ad ->views_hired = $request -> views_hired;
        $ad ->size = $request -> size;
        $ad->save();
    }
}
