<?php

use App\Http\Controllers\TagsController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\BountiesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;



Route::get('/',[StaticController::class,'index'])->name('homepage');

Route::get('/login',[StaticController::class,'login']);
Route::post('/login',[LoginController::class,'authenticate']);


Route::get('/register',[StaticController::class,'register']);
Route::post('/register',[RegisterController::class,'register']);

Route::post('/logout',[LogoutController::class,'logout']);

Route::get('/bounties', [BountiesController::class, 'index'])->name('bounties.index');
Route::get('bounties/{id}/edit', [BountiesController::class, 'edit'])->name('bounties.edit');

Route::get('/tags', [TagsController::class, 'index'])->name('tags.index');

Route::get('bounties/create', [BountiesController::class, 'create'])->name('bounties.create')->middleware('auth');
Route::post('bounties/store', [BountiesController::class, 'store'])->name('bounties.store')->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::delete('/account/delete',[UserController::class,'userDeleteAccount'])->name('account.destroy');
});

Route::get('/users/{id}',[UserController::class,'showProfile'])->name('profile');


