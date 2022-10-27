<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Referee;
use App\Models\RefereeEvent;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class RefereeController extends Controller
{
    public function create(Request $request){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok"){
            return $validation;
        }
        try {
            return $this->createReferee($request);
        }
        catch (QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot create referee');

        }

    }

    private function validateCreationRequest(Request $request){

        $validation = Validator::make($request->all(),[
            'name'=> 'required',
            'surname'=> 'required',
            'image' => 'mimes: jpg, png, jpeg'
        ]);

        if($validation->fails())
            return $validation->errors()->toJson();
        return 'ok';
        
    }

    private function createReferee(Request $request){

        $image = $this->saveImage($request, 'default_img_do_not_delete.jpg');

        Referee::create([
            'name'=> $request->name,
            'surname'=> $request->surname,
            'photo' => $image
        ]); 

        return redirect('/referee');

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

    public function index(Request $request){

        $referee = Referee::all();

        return view('referee')->with('referees', $referee);

    }

    public function update(Request $request, $id){

        $validation = $this->validateCreationRequest($request);

        if($validation !== "ok")
            return $validation;
        
        try{
                
            $this->updateRefereeData($request, $id);

            return redirect('/referee');
            
        }
        catch (QueryException $e){

            return view('error')->with('errorData',$e)->with('errors', 'Cannot update referee');
            
        }
    }

    private function updateRefereeData(Request $request, $id){

        $referee = Referee::findOrFail($id);
        $currentImage = $referee -> photo; 

        $image = $this->updateImage($request, $currentImage, $id);

        $referee -> name = $request -> name;
        $referee -> surname = $request -> surname;
        $referee -> photo = $image;
        $referee-> save();

    }

    private function updateImage(Request $request, $currentImage, $id){

        if($request->hasFile('image'))
            $this->deleteImage($id);

        return $this->saveImage($request, $currentImage);

    }
    
    private function deleteImage($id){

        $referee = Referee::findOrFail($id);
        $currentImage = $referee -> photo; 

        if($currentImage != 'default_img_do_not_delete.jpg'){

            $destinationPath = public_path('\img\public_images');
            $imagePath = $destinationPath . '/' . $currentImage;
        
            File::delete($imagePath);
    
        }

    }

    public function destroy($id){

        $validation = $this->validateDestroy($id);

        if($validation !== "ok"){
            return view('error')->with('errors', $validation);
        }
        try{
            $this->deleteImage($id);
            Referee::findOrFail($id)->delete();
            return redirect('/referee');
        }
        catch(QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot destroy referee');
        }

    }

    private function validateDestroy($id){

        if(RefereeEvent::where('id_referee',$id)->exists())
            return 'Cannot destroy referee, because it is related to an entity';
        return 'ok';
    }

}
