<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{

    public function showProfile($id)
    {
        $user = User::findorFail($id);
        return view('pages.profile', compact('user'));
    }

    public function editProfileForm($id)
    {
        $User = User::findorFail($id);
        $parsed_name = explode(' ', trim($User->name), 2);
        $firstName = $parsed_name[0];
        $lastName = $parsed_name[1];
        return view('pages.edit_profile', compact('User', 'firstName', 'lastName'));
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'firstName' => 'sometimes|string|max:30',
            'lastName' => 'sometimes|string|max:30',
            'email' => 'sometimes|email|max:60|unique:users,email,' . $user->id,
            'username' => 'sometimes|string|max:40|unique:users,username,' . $user->id,
            'password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:5|max:50',
            'bio' => 'sometimes|string|max:500',
            'location' => 'sometimes|string|max:50',
            'profilePicture' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->fill($request->only([
            'email',
            'username',
            'bio',
            'location',
        ]));

        $fullName = User::makeName($request->firstName, $request->lastName);
        $user->name = $fullName;

        if ($request->filled('new_password')) {
            if (!Hash::check($request->password, $user->password) || Hash::check($request->new_password, $user->password)) {
                return back()->withErrors([
                    'password' => 'Current password is incorrect.',
                ]);
            }
            $user->password = Hash::make($request->new_password);
        }

        if ($request->hasFile('profilePicture')) {
            $user->handlePFP($request->file('profilePicture'));
        }

        $user->save();
        return redirect(route('profile', $user->id))->with('success', 'Buckle up your profile got a new face.');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            return redirect(route('homepage'));
        }


        // NOT WORKING STILL
       $deletePFP = public_path('img/users/' . $id . '.jpg');
       if (file_exists($deletePFP)) {
            unlink($deletePFP);
        }

        $user->delete();
        return redirect(route('homepage'));
    }

    public function userDeleteAccount()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect(route('homepage'));
        }
        $user->delete();
        Auth::logout();

        return redirect()->route('homepage')->with('success', 'Your account has been deleted.');
    }
}
