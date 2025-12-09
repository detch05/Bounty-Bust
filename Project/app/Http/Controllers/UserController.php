<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;



class UserController extends Controller
{
    
    public function showProfile($id){
        $user= User::findorFail($id);
        return view('pages.profile',compact('user'));
    }


    public function destroy($id) {
        $user = User::find($id);
        if(empty($user)){
            return redirect(route('homepage'));
        }

        // DELETE OF PROFILE PICTURE NOT WORKING SEE LATER 
        $deletePFP = public_path('img/users/' . $id . '.jpg');
        if(File::exists($deletePFP)){
            File::delete($deletePFP);
        }

        $user->delete();
        return redirect(route('homepage'));
    } 
    
    public function userDeleteAccount(){
        $user = Auth::user();
        if(!$user){
            return redirect(route('homepage'));
        }
        $user->delete();
        Auth::logout();

        return redirect()->route('homepage')->with('success', 'Your account has been deleted.');
    }
}
