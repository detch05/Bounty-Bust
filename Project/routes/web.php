<?php

use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\BountiesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;



Route::get('/',[StaticController::class,'index'])->name('homepage');

// AUTHENTICATION ROUTES

Route::get('/login',[StaticController::class,'login'])->name('login');
Route::post('/login',[LoginController::class,'authenticate']);

Route::get('/register',[StaticController::class,'register']);
Route::post('/register',[RegisterController::class,'register']);

Route::post('/logout',[LogoutController::class,'logout']);

// PASSWORD RESET ROUTES
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

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

Route::prefix('tags')->name('tags.')->group(function(){
    Route::get('/',[TagsController::class,'index'])->name('index');
    Route::middleware(['auth'])->group(function () {
        Route::post('/{tagId}/follow', [TagsController::class, 'followTag'])->name('follow');
        Route::post('/{tagId}/unfollow', [TagsController::class, 'unfollowTag'])->name('unfollow');
    });
    Route::middleware(['isAdmin'])->group(function(){
        Route::get('/create',[TagsController::class,'createForm'])->name('create');
        Route::post('/store',[TagsController::class,'store'])->name('store');
        Route::get('/{id}/edit',[TagsController::class,'editForm'])->name('edit');
        Route::put('/{id}',[TagsController::class,'update'])->name('update');
        Route::delete('/{id}/delete',[TagsController::class,'destroy'])->name('destroy');
    });
});

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
Route::middleware(['auth'])->prefix('answers')->group(function(){
    Route::get('/create/{bountyId}', [AnswerController::class, 'create'])->name('answers.create');
    Route::delete('/{id}/delete', [AnswerController::class,'delete'])->name('answers.delete');
    Route::get('/{id}/edit', [AnswerController::class,'editAnswer'])->name('answers.editForm');
    Route::put('/{id}/edit', [AnswerController::class,'update'])->name('answers.update');
    Route::post('/store', [AnswerController::class, 'store'])->name('answers.store');
    Route::get('/answer/{answerId}', [AnswerController::class, 'getAnswer'])->name('answers.show');
    Route::post('/{id}/markCorrect', [AnswerController::class,'markCorrect'])->name('answers.markCorrect');
});

//ADMIN PAGE

Route::middleware(['auth','isAdmin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/',[AdminController::class,'panel'])->name('dashboard');
    Route::get('/users',[AdminController::class,'users'])->name('users');
    Route::get('/tags',[AdminController::class,'tags'])->name('tags');
    Route::get('/appeals',[AdminController::class,'appeals'])->name('appeals');
});

// COMMENTS
Route::middleware(['auth'])->prefix('comments')->group(function(){
    Route::post('/store',[CommentController::class,'store'])->name('comments.store');
    Route::delete('/{id}/delete',[CommentController::class,'delete'])->name('comments.delete');
    Route::put('/{id}/edit',[CommentController::class,'update'])->name('comments.edit');
    Route::get('/{id}/edit',[CommentController::class,'editForm'])->name('comments.editForm');
});

// CONTENT
Route::middleware(['auth'])->prefix('content')->group(function(){
    Route::post('/{content}/vote',[ContentController::class,'vote'])->name('content.vote');
    Route::post('/{content}/follow',[ContentController::class,'follow'])->name('content.follow');
});
