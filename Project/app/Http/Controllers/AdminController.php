<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function panel(){
        return view('pages.admin_panel',[
            'admin' => auth()->user()
        ]);
    }
}
