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
        $this -> checkAds();

        $validation = $this->validateCreationRequest($request);
        if ($validation !== "ok")
            return $validation;
        
        try{
            $AdListWithTags = $this->joinAdsWithTags($request);
            $possibleAds = $this->findAds($request, $AdListWithTags);
            if(count($possibleAds)<=0){
                return 'error, no ads available';
            }
            return $ad = $this->selectAd($possibleAds);

        }catch(QueryException $error){
            return $error;
        }
       
    }

    private function checkAds(){
        try{
            $adsToDelete = DB::table('ads')
            ->whereColumn('view_counter', ">=",'views_hired')
            ->get();
            if (count($adsToDelete) >= 0){
                foreach($adsToDelete as $ad){
                    $adToDelete = Ad::find($ad->id);
                    if($adToDelete != null)
                        $adToDelete->delete();
                    
                    $adTagToDelete = AdTag::find($ad->id);
                    if($adTagToDelete != null)
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
            array_push($adsViewCounter, $ad->view_counter);
        }
        $AdSelected = $ads->where('view_counter' , min($adsViewCounter))->first();
        
        $this->addView($AdSelected->id);

        return $AdSelected;

    }

    private function addView($id){
        $ad = Ad::find($id);
        $ad-> view_counter += 1;
        $ad->save();
    }

}   

