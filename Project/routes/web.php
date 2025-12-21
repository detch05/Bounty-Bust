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

// AUTHENTICATION ROUTES

Route::get('/login',[StaticController::class,'login'])->name('login');
Route::post('/login',[LoginController::class,'authenticate']);

Route::get('/register',[StaticController::class,'register']);
Route::post('/register',[RegisterController::class,'register']);

Route::post('/logout',[LogoutController::class,'logout']);

// BOUNTIES

Route::get('/bounties', [BountiesController::class, 'index'])->name('bounties.index');
Route::middleware(['auth'])->get('/bounties/{id}/edit', [BountiesController::class, 'editBounty'])->name('bounties.edit');
Route::middleware(['auth'])->put('/bounties/{id}', [BountiesController::class, 'update'])->name('bounties.update');
Route::get('bounties/create', [BountiesController::class, 'create'])->name('bounties.create')->middleware('auth');
Route::post('bounties/store', [BountiesController::class, 'store'])->name('bounties.store')->middleware('auth');
Route::get('/bounties/{bounty}', [BountiesController::class, 'show'])->name('bounties.show');
Route::middleware(['auth'])->group(function () {
    Route::delete('/bounties/{id}/delete', [BountiesController::class,'destroy'])->name('bounties.destroy');
});


// TAGS
Route::get('/tags', [TagsController::class, 'index'])->name('tags.index');
Route::middleware(['auth'])->post('/tags/{tagId}/follow', [TagsController::class, 'followTag'])->name('tags.follow');
Route::middleware(['auth'])->post('/tags/{tagId}/unfollow', [TagsController::class, 'unfollowTag'])->name('tags.unfollow');

// USER RELATED
Route::middleware(['auth'])->group(function () {
    Route::delete('/account/delete',[UserController::class,'userDeleteAccount'])->name('account.destroy');
});

Route::middleware(['auth'])->prefix('users')->group(function(){
    Route::get('/{id}',[UserController::class,'showProfile'])->name('profile');
    Route::get('/{id}/edit',[UserController::class,'editProfileForm'])->name('profile.edit');
    Route::put('/{id}',[UserController::class,'update'])->name('profile.update');
    // User-specific lists
    Route::get('/{id}/bounties', [UserController::class, 'bounties'])->name('profile.bounties');
    Route::get('/{id}/answers', [UserController::class, 'answers'])->name('profile.answers');
});

// ANSWERS

Route::post('/answers', [AnswerController::class, 'store'])->name('answers.store');

//ADMIN PAGE

Route::middleware(['auth','isAdmin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/',[AdminController::class,'panel'])->name('dashboard');
    Route::get('/users',[AdminController::class,'users'])->name('users');
    Route::get('/tags',[AdminController::class,'tags'])->name('tags');
    Route::get('/appeals',[AdminController::class,'appeals'])->name('appeals');
});
