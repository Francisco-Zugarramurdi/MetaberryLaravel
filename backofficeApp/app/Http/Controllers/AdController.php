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
        if(Ad::where('image', $request -> post("image")) -> exists())
            return 'Ad already exists';
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
            'viewsHired' => 'required',
            'image' => [
                'regex:/(?i)^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                'required'
            ]
        ]);
        if ($validator->fails())
            return $validator->errors()->toJson();
        
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

        $this->saveTag($request, $ad);

        return redirect('/ads');
    }

    private function saveTag(Request $request, $ad){

        $tagInput = $request->input('tag');
        
        foreach($tagInput as $tag){

            $tagId = Tag::where('tag', $tag)->first()->id;

            AdTag::create([
                'id_ad' => $ad ->id,
                'id_tag' => $tagId
            ]);

        }

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

        $indexAd = Ad::all();
        $tag = Tag::all();

        return view('ads')->with('ads',$indexAd)->with('tags',$tag)->with('adsModal',$ads);
    }

    public function addTag(Request $request){

        $tagInput = $request->input('tag');
        
        foreach($tagInput as $tag){

            $tagId = Tag::where('tag', $tag)->first()->id;
            DB::table('ad_tags')->insert([
                'id_ad' => $request->adId,
                'id_tag' => $tagId
            ]);

        }

        return redirect('/player');

    }

    public function update(Request $request, $id){
        $validation = $this->validateRequestCreate($request);
        
        if($validation !== "ok"){
            return $validation;
        }
        if(Ad::where('image', $request -> post("image")) -> exists() && Ad::where('image', $request -> post("image"))->first()->id != $id)
            return 'Image already exists';
        
        try{
            $this->updateAd($request, $id);
            $this->updateAdTag($request,$id);
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
        $ad ->views_hired = $request -> viewsHired;
        $ad ->size = $request -> size;
        $ad->save();
    }
    private function updateAdTag(Request $request,$id){
        $tag = Tag::where('tag',$request->tag)->get()->first()->id;
        DB::table('ad_tags')->where('id_ad',$id)->update(['id_tag'=> $tag]);
      
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