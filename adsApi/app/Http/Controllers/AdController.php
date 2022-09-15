<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\AdTag;
use Illuminate\Support\Facades\Validator;

class AdController extends Controller
{
    public function GetAd(Request $request){
        $validation = $this->validateCreationRequest($request);
        if ($validation !== "ok")
            return $validation;
        
        try{
            $AdListWithTags = $this->JoinAdsWithTags($request);
            $possibleAds = $this->findAds($request, $AdListWithTags);
            $ad = $this->selectAd($possibleAds);
            $ad;
        }catch(QueryException $error){
            return $error;
        }
       
    }

    public function testAdTag(Request $request){
        $AdListWithTags = $this->JoinAdsWithTags($request);
        $possibleAds = $this->findAds($request, $AdListWithTags);
        $ad = $this->selectAd($possibleAds);
        $ad;
    }
    
    public function testAd(){
        return $ad = Ad::all();
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

    private function JoinAdsWithTags(Request $request){
        return $AdWithTags = Ad::join("ad_tags","ad_tags.ad_id", "=", "ads.id")
            ->select("*")
            ->where('size', $request->size)
            ->where('tag', $request->tag)
            ->get();
    }

    private function findAds(Request $request, $adList){
        return $ads = $adList
            ->where('size', $request->size)
            ->where('tag', $request->tag);
    }

    private function selectAd($ads){
        return "hola";
        foreach ($ads as $ad){
            $adsViewCounter[] = $ad->view_counter;
        }
        return $adsViewCounter;
        return $AdSelected = $ads[array_search(min($adsViewCounter), $adsViewCounter)];

    }

}   

