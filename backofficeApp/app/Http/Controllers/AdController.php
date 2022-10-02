<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ad;
use App\Models\AdTag;
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

        if(Ad::withTrashed()->where('image', $request -> post("image")) -> exists())
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
        AdTag::create([
            'ad_id' => $ad ->id,
            'tag' => $request -> post("tag"),
        ]);
        return redirect('/ads');
    }

    public function index(){
        $ads = Ad::join("ad_tags","ad_tags.ad_id", "=", "ads.id")
        ->select("*")
        ->get();
        return view('ads')->with('ads',$ads);
    }

    public function update(Request $request, $id){

        try{
            $this->updateAd($request, $id);
            return redirect('/ads');
        }catch(QueryException $e){

            return [
                "error" => 'Cannot update ad',
                "trace" => $e -> getMessage()
            ];
            
        }
        
    }

    private function updateAd(Request $request, $id){
        $ad = Ad::findOrFail($id);
        $ad ->image = $request -> image;
        $ad ->url = $request -> url;
        $ad ->views_hired = $request -> views_hired;
        $ad ->size = $request -> size;
        $ad->save();
    }

    public function destroy($id){
        try{
            $ad = Ad::findOrFail($id);
            $ad -> delete();
            return redirect('/ads');
        }catch(QueryException $e){
            return [
                "error" => 'Cannot delete ad',
                "trace" => $e -> getMessage()
            ];
        }
    }
}