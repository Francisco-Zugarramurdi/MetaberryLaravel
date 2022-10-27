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
use App\Models\UserSubscription;
use \Illuminate\Database\QueryException;
use Carbon\Carbon;
class UserController extends Controller
{
    
    public function indexByEmail($email){

        $user = User::where('email', $email)->first();

        if (! $user) 
            return view('error')->with('errors', "error User" . $email . "does not exist");
            
        return $user;

    }

    public function index(){

        $users = UserData::join('users','users.id','users_data.id')
        ->get();

        return view('users')->with('users',$users);
    }

    public function create(Request $request){

        $validation = $this->validateRequest($request);

        if($validation !== "ok"){
            return view('error')->with('errors', $validation); 
        }
        try {
            return $this->createUser($request);
        }
        catch (QueryException $e){
           return $e;
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
            'credit_card' => 'regex:/^4[0-9]{12}(?:[0-9]{3})?$/|nullable'
            
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
        $creditCard = $this->validateCreditCard($request);

        $user = UserData::create([

            'name' => $request -> name,
            'photo' => $image,
            'points' => $request -> points,
            'type_of_user' => $request -> type_of_user,
            'total_points' => $request -> total_points,
            'credit_card' => $creditCard

        ]);
        
        User::create([

            'id' => $user ->id,
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => Hash::make($request -> password)

        ]);

        $this->createSubscription($request, $user -> id);

        return redirect('/user');

    }

    private function validateCreditCard(Request $request){

        $creditCard = $request -> credit_card;

        if($creditCard !== null)
            return $creditCard;
        return '';
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
            return view('error')->with('errors', 'Cannot update user');
            
        }

    }

    private function updateUserData(Request $request, $id){

        $user = UserData::findOrFail($id);
        $currentImage = $user -> photo; 

        $image = $this->updateImage($request, $currentImage, $id);
        $creditCard = $this->validateCreditCard($request);
        $this->updateUserSubscription($request, $user-> type_of_user, $id);

        $user -> name = $request -> name;
        $user -> credit_card = $creditCard;
        $user -> photo = $image;
        $user -> points = $request -> points;
        $user -> type_of_user = $request -> type_of_user;
        $user -> total_points = $request -> total_points;
        $user -> save();

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
            return $this->delete($id);
        }
        catch(QueryException $e){
            return view('error')->with('errorData',$e)->with('errors','Cannot delete user');
        }
    }

    private function delete($id){

        $user = User::findOrFail($id);
        $userData = UserData::findOrFail($id);

        $this->deleteImage($id);
        UserSubscription::where('id_users', $id)->delete();

        $user->delete();
        $userData->delete();

        return redirect('/user');

    }

    public function indexSubscription(){

        $subscription = UserData::join('users','users.id','users_data.id')
        ->join('users_subscriptions','users_subscriptions.id_users','users_data.id')
        ->where('users_subscriptions.deleted_at', null)
        ->select('users_data.id as userID', 'users_data.photo as photo',
        'users_data.type_of_user as type_of_user', 'users.email as email',
        'users_subscriptions.type_of_subscription as subscription', 'users_subscriptions.id as id')
        ->get();

        return view('usersubscription')->with('subscriptions',$subscription);

    }

    private function createSubscription(Request $request, $id){

        if($request-> type_of_user == 'paid_monthly' || $request-> type_of_user == 'paid_yearly'){

            UserSubscription::create([
    
                'id_users' => $id,
                'type_of_subscription' => $request -> type_of_user
    
            ]);

        }

    }

    private function updateUserSubscription(Request $request, $typeOfUser, $id){

        if($typeOfUser == 'free'){

            return $this->createSubscription($request, $id);

        }

        $this->validateSubscriptionUpdate($request, $id);

    }

    private function validateSubscriptionUpdate($request, $id){

        if($request-> type_of_user == 'free'){

            return UserSubscription::where('id_users', $id)->delete();

        }

        UserSubscription::where('id_users', $id)
        ->update([
            'type_of_subscription' => $request -> type_of_user
        ]);

    }

    public function destroySubscription($id){

        try{

            $this->updateSubscriptionOnDelete($id);
            UserSubscription::findOrFail($id)->delete();
            
            return redirect('/user/subscription');

        }
        catch(QueryException $e){
            return $e;
        }

    }

    private function updateSubscriptionOnDelete($id){

        $subscription = UserSubscription::findOrFail($id);
        $userID = $subscription -> id_users;

        $user = UserData::findOrFail($userID);
        $user -> type_of_user = 'free';
        $user -> save();

    }

    public function updateSubscription(Request $request, $id){
        
        try{
            
            $subscription = UserSubscription::findOrFail($id);
            $user = UserData::findOrFail($subscription -> id_users);

            $subscription -> type_of_subscription = $request -> type_of_user;
            $subscription-> save();
            $user -> type_of_user = $request -> type_of_user;
            $user -> save();

            return redirect('/user/subscription');
            
        }
        catch (QueryException $e){
            return view('error')->with('errors', 'Cannot update subscription');
            
        }

    }
    

}
