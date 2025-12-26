<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\AccessoriesController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NewsletterController;
// =========================================================
// 🏠 General Pages
// =========================================================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/faq', [FaqController::class, 'index'])->name('faq');

// หน้าขั้นตอนการสั่งซื้อสินค้า
Route::get('/order-guide', function () {
    return view('order-guide');
})->name('order-guide'); 

// ✅ เพิ่มเติม: หน้าวิธีการชำระเงิน
Route::get('/payment-method', function () {
    return view('payment-method');
})->name('payment-method');

// ✅ เพิ่มเติม: Route สำรองสำหรับหน้าอื่นๆ (กัน Error 404 ในเมนูนำทาง)
Route::get('/design-guide', function () { return view('design-guide'); })->name('design-guide');
Route::get('/cookie-policy', function () {
    return view('cookie-policy');
})->name('cookie-policy');

// =========================================================
// 🛍️ Product System
// =========================================================
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{slug}', [ProductController::class, 'showByCategory'])->name('products.category');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/product/calculate', [ProductController::class, 'calculatePrice'])->name('product.calculate');

// =========================================================
// 🛒 Cart System (Cookie Based)
// =========================================================
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');

// =========================================================
// 📄 Quotation System (Flow ขอใบเสนอราคา)
// =========================================================
Route::get('/quotation', [QuotationController::class, 'index'])->name('quotation.index');
Route::post('/quotation/step1', [QuotationController::class, 'storeStep1'])->name('quotation.step1');
Route::get('/quotation/tax-info', [QuotationController::class, 'taxInfo'])->name('quotation.tax_info');
Route::post('/quotation/confirm', [QuotationController::class, 'confirmQuotation'])->name('quotation.confirm');

// Result: หน้าแสดงใบเสนอราคา
Route::get('/quotation/view/{id}', [QuotationController::class, 'show'])->name('quotation.show');

Route::get('/send-test-email', [HomeController::class, 'sendTestEmail'])->name('send.test.email');

Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact-full', [ContactController::class, 'full'])->name('contact.full');
Route::get('/contact/success', [ContactController::class, 'success'])->name('contact.success');

Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');

Route::get('/accessories', function () {
    return view('accessories'); // ชื่อไฟล์ accessories.blade.php
})->name('accessories');

Route::get('/accessories', [AccessoriesController::class, 'index'])->name('accessories');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

Route::post('/newsletter-subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');