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
            $ad = this->findAd($request);
            return $ad->url;

        }catch(QueryException $error){
            return $error;
        }
       
    }

    public function test(){
        return $ad = Ad::all()->where('url', 'test.com')->where('size', 'large');
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

    private function findAd(Request $request){
        return $ads = Ad::all()->where('size', $request->size)->adTag->where('tag', $request->tag);
    }
}
