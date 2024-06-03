<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class accountController extends Controller
{
    public function register(){
        return view('front.account.register');
    }

    public function registerProcess(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5',
            'email' => 'required|unique:users',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required'
        ]);

        if($validator->fails()){
            session()->flash('error','check again all fields');
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }else{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success','you have registerd successfully');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        }     
    }


    public function login(){
         return view('front.account.login');
    }


    public function authentication(Request $request){

        $validator = validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validator->passes()){
          if( Auth::attempt(['email'=>$request->email , 'password'=>$request->password])){

            session()->flash('success','you have logged in .this is your profile page');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
          }
        }else{
            session()->flash('error','check your cradentials');
            return response()->json([
                'status' =>false,
                'errors' => $validator->errors()
            ]);
        }
   }



   public function profile(){
            $id = Auth::user()->id;

            $user = user::find($id);
            return view('front.account.profile',compact('user'));
        }



   public function updateProfile(Request $request){

            $id = Auth::user()->id;
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id.',id'
            ];
            if(!empty($request->image)){
                $rules['image'] = 'image|mimes:jpeg,png,jpg,gif';
            }
            $validator = Validator::make($request->all(),$rules);

            if($validator->passes()){
                $user = User::findOrFail($id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->save();

                if(!empty($request->image)){
                    File::delete(public_path('uploads/profile/'.$user->image));
                    File::delete(public_path('uploads/profile/thumb/'.$user->image));

                    $image = $request->image;
                    $ext = $image->getClientOriginalExtension();
                    $imageName = $id.time().'.'.$ext;
                    $image->move(public_path('uploads/profile'),$imageName);
                    $user->image = $imageName;
                    $user->save();
    
                    $manager = new ImageManager(Driver::class);
                    $img = $manager->read(public_path('uploads/profile/'.$imageName));
                    $img->cover(150, 150);
                    $img->save(public_path('uploads/profile/thumb/'.$imageName));
                }
                
                session()->flash('success','profile updated successfully');
                return response()->json([
                    'status' => true,
                    'errors' => []
                ]);                
            }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }
   }
   
   
   public function logout(){
       Auth::logout();
        return redirect()->route('account.login')->with('success','you have successfully logged out');
   }





}
