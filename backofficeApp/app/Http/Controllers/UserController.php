<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\UserData;
use \Illuminate\Database\QueryException;
class UserController extends Controller
{

    public function create(Request $request){

        $validation = $this->validateRequest($request);

        if($validation !== "ok"){
            return view('error')->with('errors', $validation); 
        }
        try {
            return $this->createUser($request);
        }
        catch (QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot create user');
        }
        
    }

    private function validateRequest(Request $request){

        $validationRequest = $this->validateCreationRequest($request);

        if($validationRequest !== "ok")
            return $validationRequest;

        $validationRegexRequest = $this->validateRegexRequest($request);

        if($validationRegexRequest !== "ok")
            return $validationRegexRequest;
        return "ok";

    }

    private function validateRegexRequest(Request $request){

        $validator = Validator::make($request->all(),
        [

            'email' => 'regex:/(?i)^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
            'password' => 'regex:^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
            'credit_card' => 'regex:/^4[0-9]{12}(?:[0-9]{3})?$/'
            
        ]);

        if($validator->fails())
            return $validator->errors()->toJson();
        return 'ok';

    }

    private function validateCreationRequest(Request $request){

        $validator = Validator::make($request->all(),[

            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'points' => 'required',
            'type_of_user' => 'required',
            'total_points' => 'required'

        ]);

        if($validator->fails())
            return $validator->errors();

        if(User::withTrashed()->where('email', $request -> post("email")) -> exists())
            return view('error')->with('errors', 'User already exists');
            
        return 'ok';

    }

    private function createUser(Request $request){

        $image = $this->saveImage($request, 'default_img_do_not_delete.jpg');

        $user = UserData::create([

            'name' => $request -> post("name"),
            'credit_card' => $request -> post("credit_card"),
            'photo' => $image,
            'points' => $request -> post("points"),
            'type_of_user' => $request -> post("type_of_user"),
            'total_points' => $request -> post("total_points")

        ]);
        
        User::create([

            'id' => $user ->id,
            'name' => $request -> post("name"),
            'email' => $request -> post("email"),
            'password' => Hash::make($request -> post("password"))

        ]);
        return redirect('/user');

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

    public function indexByEmail($email){

        $user = User::where('email', $email)->first();

        if (! $user) 
            return view('error')->with('errors', "error User" . $email . "does not exist");
            
        return $user;

    }

    public function index(){
        $users = UserData::join('users','users.id','=','users_data.id')->get();
        return view('users')->with('users',$users);

    }

    public function update(Request $request, $id){

        $validation = $this->validateRegexRequest($request);
        
        if($validation !== "ok")
            return view('error')->with('errors', $validation); 
        
        try{
                
            $this->updateUserData($request, $id);
            $this->updateUserCredentials($request, $id);

            return redirect('/user');
            
        }
        catch (QueryException $e){
            return view('error')->with('errorData',$e)->with('errors', 'Cannot update user');
            
        }

    }

    private function updateUserData(Request $request, $id){

        $user = UserData::findOrFail($id);
        $currentImage = $user -> photo; 

        $image = $this->updateImage($request, $currentImage, $id);

        $user -> name = $request -> name;
        $user -> credit_card = $request-> credit_card;
        $user -> photo = $image;
        $user -> points = $request -> points;
        $user -> type_of_user = $request -> type_of_user;
        $user -> total_points = $request -> total_points;
        $user-> save();

    }

    private function updateImage(Request $request, $currentImage, $id){

        if($request->hasFile('image'))
            $this->deleteImage($id);

        return $this->saveImage($request, $currentImage);

    }
    
    private function deleteImage($id){

        $user = UserData::findOrFail($id);
        $currentImage = $user -> photo; 

        if($currentImage != 'default_img_do_not_delete.jpg'){

            $destinationPath = public_path('\img\public_images');
            $imagePath = $destinationPath . '/' . $currentImage;
        
            File::delete($imagePath);
    
        }

    }

    private function updateUserCredentials(Request $request, $id){
        $user = User::findOrFail($id);
        $user -> name = $request -> name;
        $user -> email = $request -> email;
        $user-> save();

    }

    public function destroy($id){
        try{
            $user = User::findOrFail($id);
            $userData = UserData::findOrFail($id);
            $this->deleteImage($id);
            $user->delete();
            $userData->delete();
            return redirect('/user');
        }
        catch(QueryException $e){
            return view('error')->with('errorData',$e)->with('errors','Cannot delete user');
        }
        
    }


}