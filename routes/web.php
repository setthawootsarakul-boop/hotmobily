<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\QuotationController;


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

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');

Route::get('/quotation', [QuotationController::class, 'index'])->name('quotation.index');
Route::post('/quotation/step1', [QuotationController::class, 'storeStep1'])->name('quotation.step1'); // เปลี่ยนชื่อจาก store_temp

// Route สำหรับ Step 2 (ใบกำกับภาษี)
Route::get('/quotation/tax-info', [QuotationController::class, 'taxInfo'])->name('quotation.tax_info');
Route::post('/quotation/confirm', [QuotationController::class, 'confirmQuotation'])->name('quotation.confirm');

Route::get('/quotation/success/{id}', [QuotationController::class, 'show'])->name('quotation.show');