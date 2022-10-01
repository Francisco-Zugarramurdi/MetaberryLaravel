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
        return  $ads = $AdWithTags = Ad::join("ad_tags","ad_tags.ad_id", "=", "ads.id")
            ->get()
            ->where('size', $request->size)
            ->where('tag', $request->tag);
    }

    private function selectAd($ads){
        $adsViewCounter = array();
        foreach($ads as $ad){
            array_push($adsViewCounter, $ad->view_counter);
        }
        $AdSelected = $ads->where('view_counter' , min($adsViewCounter))->first();
        
        $this->addView($AdSelected->ad_id);

        return $AdSelected;

    }

    private function addView($id){
        $ad = Ad::find($id);
        $ad-> view_counter += 1;
        $ad->save();
        if($ad->view_couner == $ad->views_hired){
            $ad->delete();
            AdTag::find($ad->ad_id)->delete();
        }
    }

}   

