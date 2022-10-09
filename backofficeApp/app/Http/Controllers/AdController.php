<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ad;
use App\Models\AdTag;
use App\Models\Tag;
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
            'viewsHired' => 'required'
        ]);
        if ($validator->fails())
            return $validator->errors()->toJson();

        if(Ad::where('image', $request -> post("image")) -> exists())
            return 'Image already exists';

        if(!Tag::where('tag', $request -> post("tag")) -> exists())
            return 'Tag does not  exists';
        
        return 'ok';
    }

    private function createAd(Request $request){
        $ad = Ad::create([
            'image' => $request -> post("image"),
            'url' => $request -> post("url"),
            'views_hired' => $request -> post("viewsHired"),
            'size' => $request -> post("size"),
            'view_counter' => 0
        ]);

        AdTag::create([
            'id_ad' => $ad ->id,
            'id_tag' => Tag::where('tag', $request -> post("tag"))->first()->id
        ]);
        return redirect('/ads');
    }

    public function index(){

        $ads = Ad::join('ad_tags', 'ad_tags.id_ad', 'ads.id')
        ->join('tags','tags.id','ad_tags.id_tag')
        ->select("ads.id as id",
         "ads.image as image",
          "ads.url as url",
          "ads.size as size",
          "ads.views_hired as views_hired",
          "ads.view_counter as view_counter",
          "tags.tag as tag")
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