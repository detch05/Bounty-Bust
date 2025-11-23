<?php

use App\Http\Controllers\StaticController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;



Route::get('/',[StaticController::class,'index']);

Route::get('/login',[StaticController::class,'login']);
Route::post('/login',[LoginController::class,'authenticate']);


Route::get('/register',[StaticController::class,'register']);
Route::post('/register',[RegisterController::class,'register']);

Route::post('/logout',[LogoutController::class,'logout']);