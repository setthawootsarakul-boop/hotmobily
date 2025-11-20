<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProductController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/contact-full', [ContactController::class, 'full'])->name('contact.full');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/order-guide', function () {
    return view('order-guide');
})->name('order-guide');    

// หน้ารายการสินค้าทั้งหมด (และกรอง)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// หน้าแสดงสินค้าตามหมวดหมู่ (Optional)
Route::get('/products/category/{slug}', [ProductController::class, 'showByCategory'])->name('products.category');

// ✅ (แก้ไข) หน้ารายละเอียดสินค้า (ใช้ {slug} เพื่อความชัดเจน)
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/product/calculate', [ProductController::class, 'calculatePrice'])->name('product.calculate');