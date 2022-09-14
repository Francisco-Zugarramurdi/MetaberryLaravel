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
            $possibleAds = this->findAds($request);
            $ad = this->selectAd($possibleAds);
            return $ad->url;

        }catch(QueryException $error){
            return $error;
        }
       
    }

    public function testAdTag(){
        return $ad = Ad::all()->adTag;
    }
    public function testAd(){
        return $ad = Ad::all();
    }

    private function validateCreationRequest(Request $request){
        $validator = Validation::make($request->all(),[
            'size' => 'requierd',
            'tag' => 'required'
        ]);
        if ($validator->fails())
            return $validator->errors()->toJson();
        return "ok";

        
    }

    private function findAds(Request $request){
        return $ads = Ad::all()->where('size', $request->size)->adTag->where('tag', $request->tag);
    }

    private function selectAd(array $ads){
        
    }
}   

