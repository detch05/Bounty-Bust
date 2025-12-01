<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\BountiesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;



Route::get('/',[StaticController::class,'index'])->name('homepage');

Route::get('/login',[StaticController::class,'login'])->name('login');
Route::post('/login',[LoginController::class,'authenticate']);


Route::get('/register',[StaticController::class,'register']);
Route::post('/register',[RegisterController::class,'register']);

Route::post('/logout',[LogoutController::class,'logout']);

Route::get('/bounties', [BountiesController::class, 'index'])->name('bounties.index');
Route::middleware(['auth'])->get('/bounties/{id}/edit', [BountiesController::class, 'editBounty'])->name('bounties.edit');
Route::middleware(['auth'])->put('/bounties/{id}', [BountiesController::class, 'update'])->name('bounties.update');

Route::middleware(['auth'])->group(function () {
    Route::delete('/bounties/{id}/delete', [BountiesController::class,'destroy'])->name('bounties.destroy');
});



Route::get('/tags', [TagsController::class, 'index'])->name('tags.index');

Route::get('bounties/create', [BountiesController::class, 'create'])->name('bounties.create')->middleware('auth');
Route::post('bounties/store', [BountiesController::class, 'store'])->name('bounties.store')->middleware('auth');
Route::get('/bounties/{bounty}', [BountiesController::class, 'show'])->name('bounties.show');
Route::middleware(['auth'])->group(function () {
    Route::delete('/account/delete',[UserController::class,'userDeleteAccount'])->name('account.destroy');
});

Route::get('/users/{id}',[UserController::class,'showProfile'])->name('profile');


Route::post('/answers', [AnswerController::class, 'store'])->name('answers.store');


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/',[AdminController::class,'panel'])->name('dashboard');

});
