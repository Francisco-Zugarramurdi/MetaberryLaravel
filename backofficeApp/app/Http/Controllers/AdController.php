<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ad;
use App\Models\AdTag;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use \Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class AdController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Create(Request $request){

        $validation = $this->validateRequestCreate($request);
        
        if($validation !== "ok"){
            return $validation;
        }
        try{

            return $this->createAd($request);

        }catch(QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot create ad');

        }
    }

    
    private function validateRequestCreate(Request $request){
        $validator = Validator::make($request->all(),[
            'size' => 'required',
            'tag' => 'required',
            'url' => [
                'regex:/(?i)^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                'required'
            ],
            'viewsHired' => 'required'
        ]);
        if ($validator->fails())
            return $validator->errors()->toJson();
        
        return 'ok';
    }

    private function createAd(Request $request){

        $image = $this->saveImage($request, 'default_img_do_not_delete.jpg');

        $ad = Ad::create([
            'image' => $image,
            'url' => $request -> post("url"),
            'views_hired' => $request -> post("viewsHired"),
            'size' => $request -> post("size"),
            'view_counter' => 0
        ]);

        $this->saveTag($request, $ad);

        return redirect('/ads');
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


    private function deleteImage($id){

        $ad = Ad::findOrFail($id);
        $currentImage = $ad -> image; 

        if($currentImage != 'default_img_do_not_delete.jpg'){

            $destinationPath = public_path('\img\public_images');
            $imagePath = $destinationPath . '/' . $currentImage;
        
            File::delete($imagePath);
    
        }
    
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

    public function Index(){

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

        $indexAd = Ad::paginate(10);
        $tag = Tag::all();

        return view('ads')->with('ads',$indexAd)->with('tags',$tag)->with('adsModal',$ads);
    }

    public function AddTag(Request $request,$id){

        $tagInput = $request->input('tag');
        
        foreach($tagInput as $tag){

            $tagId = Tag::where('tag', $tag)->first()->id;
            $adTag = AdTag::where('id_ad',$id)->where('id_tag',$tagId);
            if(!$adTag->exists()){
                DB::table('ad_tags')->insert([
                    'id_ad' => $id,
                    'id_tag' => $tagId
                ]);
            }
          

        }

        return redirect('/player');

    }

    public function Update(Request $request, $id){
        
        $validation = $this->validateRequestCreate($request);
        
        if($validation !== "ok"){
            return $validation;
        }
        try{

            $this->updateAd($request, $id);
            $this->addTag($request,$id);
            return redirect('/ads');

        }catch(QueryException $e){
            
            return $e;
            
        }
        
    }

    private function updateAd(Request $request, $id){

        $ad = Ad::findOrFail($id);
        $currentImage = $ad -> image; 

        $image = $this->updateImage($request, $currentImage, $id);

        $ad -> image = $image;
        $ad -> url = $request -> url;
        $ad -> views_hired = $request -> viewsHired;
        $ad -> size = $request -> size;
        $ad-> save();
    }

    private function updateImage(Request $request, $currentImage, $id){

        if($request->hasFile('image'))
            $this->deleteImage($id);

        return $this->saveImage($request, $currentImage);

    }

    private function updateAdTag(Request $request,$id){

        $tag = Tag::where('tag',$request->tag)->get()->first()->id;
        DB::table('ad_tags')->where('id_ad',$id)->update(['id_tag'=> $tag]);
      
    }
    
    public function Destroy($id){

        try{

            return $this->delete($id);

        }catch(QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot destroy ad');

        }
    }

    private function delete($id){

        $ad = Ad::findOrFail($id);
        $this->deleteImage($id);

        $ad -> delete();

        return redirect('/ads');

    }
}

