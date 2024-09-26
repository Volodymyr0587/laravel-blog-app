<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
