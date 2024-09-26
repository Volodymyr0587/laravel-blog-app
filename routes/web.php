<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

//% welocme page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');

Route::name('blog.')->group(function () {
    //% blog page
    Route::get('/blog', [BlogController::class, 'index'])->name('index');
    //% single blog post
    Route::get('/blog/single-blog-post', [BlogController::class, 'show'])->name('show');
    //% about page
    Route::view('/about', 'about')->name('about');
    //% contact page
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');

});

