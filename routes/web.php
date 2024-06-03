<?php

use App\Http\Controllers\accountController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\reviewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('home-page',[homeController::class ,'home'])->name('index.home');
Route::get('detail-page/{id}',[homeController::class ,'detail'])->name('index.detail');
Route::POST('book-review-store',[homeController::class ,'addBookReview'])->name('book.review');
// Route::get('reviews-page',[reviewsController::class ,'reviews'])->name('book.reviews');




Route::group(['prefix'=>'account' ],function(){
    Route::group(['middleware' => 'guest'],function(){
       
        Route::get('register',[accountController::class , 'register'])->name('account.register');
        Route::POST('register-process',[accountController::class , 'registerProcess'])->name('account.registerProcess');
        Route::get('login',[accountController::class , 'login'])->name('account.login');
        Route::POST('/login/authentication',[accountController::class , 'authentication'])->name('account.authentication');

    });

    Route::group(['middleware' => 'auth'],function(){

        Route::get('profile',[accountController::class , 'profile'])->name('account.profile');
        Route::POST('/update/profile',[accountController::class , 'updateProfile'])->name('account.updateProfile');
        Route::get('logout',[accountController::class , 'logout'])->name('account.logout');
    //   book routes starts
        Route::get('/list-book',[bookController::class , 'index'])->name('book.list');
        Route::get('/create-book',[bookController::class , 'create'])->name('book.create');
        Route::POST('/store-book',[bookController::class , 'store'])->name('book.store');
        Route::get('/edit-book/{id}',[bookController::class , 'edit'])->name('book.edit');
        Route::POST('/update-book/{id}',[bookController::class , 'update'])->name('book.update');
        Route::delete('/delete-book',[bookController::class , 'destroy'])->name('book.delete');
        Route::get('reviews-page',[reviewsController::class ,'allReviews'])->name('book.reviews');


    });

});
