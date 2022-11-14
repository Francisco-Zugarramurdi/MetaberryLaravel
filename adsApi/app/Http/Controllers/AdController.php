<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\AdTag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdController extends Controller
{
    public function getAd(Request $request){

        $validation = $this->validateCreationRequest($request);
        if ($validation !== "ok")
            return $validation;
        
        try{
            $possibleAds = $this->findAds($request);
            if(count($possibleAds)==0){
                return 'error, no ads available';
            }
            return $ad = $this->selectAd($possibleAds);

        }catch(QueryException $error){
            return $error;
        }
       
    }

    private function validateCreationRequest(Request $request){
        $validator = Validator::make($request->all(),[
            'size' => 'required',
            'tag' => 'required'
        ]);
        if ($validator->fails())
            return $validator->errors()->toJson();
        return "ok";

        
    }

    private function findAds(Request $request){
        return $ads = Ad::join('ad_tags', 'ad_tags.id_ad', 'ads.id')
            ->join('tags','tags.id','ad_tags.id_tag')
            ->select("ads.id as id",
            "ads.image as image",
            "ads.url as url",
            "ads.size as size",
            "ads.views_hired as views_hired",
            "ads.view_counter as view_counter",
            "tags.tag as tag",
            "ad_tags.id_tag as idTag",
            "ad_tags.id_ad as idAd")
            ->where('size', $request->size)
            ->where('tag', $request->tag)
            ->get();
    }

    private function selectAd($ads){
        
        $AdSelected = $ads->sortBy('view_counter')->first();
        $this->addView($AdSelected->id);
        return $AdSelected;
    }

    private function addView($id){
        $ad = Ad::find($id);
        $ad-> view_counter ++;
        $ad->save();
        if($ad->view_counter == $ad->views_hired){
            $ad->delete();
        }
    }

}   

