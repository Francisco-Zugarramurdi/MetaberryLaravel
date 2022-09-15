<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\AdTag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdController extends Controller
{
    public function GetAd(Request $request){
        
        $validation = $this->validateCreationRequest($request);
        if ($validation !== "ok")
            return $validation;
        
        try{
            $AdListWithTags = $this->joinAdsWithTags($request);
            $possibleAds = $this->findAds($request, $AdListWithTags);
            $ad = $this->selectAd($possibleAds);
            $ad;
        }catch(QueryException $error){
            return $error;
        }
       
    }

    private function checkAds(){
        try{
            $adsToDelete = DB::table('ads')
            ->whereColumn('view_counter', ">=",'views_hired')
            ->get();
            if ($count($adsToDelte) >= 0){
                foreach($adsToDelete as $ad){
                    $adToDelete = Ad::find($ad->id);
                    $adToDelete->delete();

                    $adTagToDelete = AdTag::find($ad->id);
                    $adTagToDelete->delete();
                }
            }
            
            
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

    private function joinAdsWithTags(Request $request){
        return $AdWithTags = Ad::join("ad_tags","ad_tags.ad_id", "=", "ads.id")
            ->select("*")
            ->get();
    }

    private function findAds(Request $request, $adList){
        return $ads = $adList
            ->where('size', $request->size)
            ->where('tag', $request->tag);
    }

    private function selectAd($ads){

        $adsViewCounter = array();
        foreach($ads as $ad){
            $adsViewCounter[] = $ad->view_counter;
        }

        $adArray = (array) $ads;
        $AdSelected = $ads->where('view_counter' , min($adsViewCounter))->first();
        
        $this->addView($AdSelected->id);

        return $AdsSelected;

    }


    private function addView($id){
        $ad = Ad::find($id);
        $ad->save();
    }

}   

