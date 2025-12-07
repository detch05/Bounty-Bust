<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function panel(){
        return view('pages.admin_panel',[
            'admin' => auth()->user()
        ]);
    }

    public function users(){
        $users = User::all();
        return view('partials.admin.users_card',compact('users'));
    }

    public function tags(){
        $tags = Tag::all();
        return view('partials.admin.tags_card');
    }

    public function appeals(){
        return view('partials.admin.appeals_card');
    }
}
