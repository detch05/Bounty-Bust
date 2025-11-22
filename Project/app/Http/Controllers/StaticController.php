<?php

namespace App\Http\Controllers;


# Static controller with no variable based methods, only returns page views (MediaLibrary example)
class StaticController extends Controller
{
    public function index(){
        return view('pages.home');
    }
}
