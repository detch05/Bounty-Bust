<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


# Static controller with no variable based methods, only returns page views (MediaLibrary example)
class StaticController extends Controller
{
    public function index(){
        return view('pages.home');
    }

    public function login(){
        return view('pages.auth.login');
    }

    public function register(){
        return view('pages.auth.register');
    }

}
