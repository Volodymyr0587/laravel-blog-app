<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchPostController;
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
    //% about page
    Route::view('/about', 'about')->name('about');
    //% contact page
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');

    Route::middleware('auth')->group(function () {
        //% create, update, delete posts
        Route::get('/blog/create', [BlogController::class, 'create'])->name('create');
        Route::post('/blog', [BlogController::class, 'store'])->name('store');
        Route::get('/blog/{post}/edit', [BlogController::class, 'edit'])->name('edit');
        Route::put('/blog/{post}', [BlogController::class, 'update'])->name('update');
        Route::delete('/blog/{post}', [BlogController::class, 'destroy'])->name('destroy');
        //% Send Contact Us Email
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    });

    //% Search blog post
    Route::get('/blog/search', SearchPostController::class)->name('search');
    //% Filter blog posts by category
    Route::get('/blog/category/{category}', [BlogController::class, 'filterByCategory'])->name('filterByCategory');
    //% Filter blog posts by user
    Route::get('/blog/user/{user}', [BlogController::class, 'filterByUser'])->name('filterByUser');
    //% single blog post
    Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('show');
});

//% Category resource controller
Route::resource('/categories', CategoryController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
