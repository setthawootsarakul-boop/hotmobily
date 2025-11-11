<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;



Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/contact-full', [ContactController::class, 'full'])->name('contact.full');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/order-guide', function () {
    return view('order-guide');
})->name('order-guide');    
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
