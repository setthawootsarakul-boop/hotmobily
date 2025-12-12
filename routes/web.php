<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\QuotationController;

// =========================================================
// 🏠 General Pages
// =========================================================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
Route::get('/contact-full', [ContactController::class, 'full'])->name('contact.full');

Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/order-guide', function () {
    return view('order-guide');
})->name('order-guide');    

// =========================================================
// 🛍️ Product System
// =========================================================
// หน้ารายการสินค้าทั้งหมด
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// หน้าแสดงสินค้าตามหมวดหมู่
Route::get('/products/category/{slug}', [ProductController::class, 'showByCategory'])->name('products.category');

// หน้ารายละเอียดสินค้า
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// API คำนวณราคา (AJAX)
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
// Step 1: กรอกที่อยู่จัดส่ง (รับ selected_items จาก Cart หรือ URL)
Route::get('/quotation', [QuotationController::class, 'index'])->name('quotation.index');
Route::post('/quotation/step1', [QuotationController::class, 'storeStep1'])->name('quotation.step1');

// Step 2: ข้อมูลใบกำกับภาษี
Route::get('/quotation/tax-info', [QuotationController::class, 'taxInfo'])->name('quotation.tax_info');

// Final: บันทึกข้อมูลลง Database
Route::post('/quotation/confirm', [QuotationController::class, 'confirmQuotation'])->name('quotation.confirm');

// Result: หน้าแสดงใบเสนอราคา (A4 / PDF View)
// ✅ แก้ไข: เหลือบรรทัดเดียว เพื่อไม่ให้ชื่อซ้ำกัน
Route::get('/quotation/view/{id}', [QuotationController::class, 'show'])->name('quotation.show');