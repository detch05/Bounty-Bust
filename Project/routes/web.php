<?php

use App\Http\Controllers\StaticController;



Route::get('/',[StaticController::class,'index']);
Route::get('/login',[StaticController::class,'login']);
Route::get('/register',[StaticController::class,'register']);
