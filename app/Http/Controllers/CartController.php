<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Product; // อย่าลืม Model Product

class CartController extends Controller
{
    // แสดงหน้าตะกร้า
    public function index(Request $request)
    {
        // 1. ดึงข้อมูลจาก Cookie (ชื่อ 'shopping_cart')
        $cookieData = $request->cookie('shopping_cart');
        $cartItems = $cookieData ? json_decode($cookieData, true) : [];

        // 2. ดึงข้อมูลสินค้าจริงจาก DB ตาม ID ที่อยู่ใน Cookie เพื่อเอารูปและชื่อ
        $products = [];
        if (!empty($cartItems)) {
            $productIds = array_column($cartItems, 'product_id');
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        }

        return view('cart', compact('cartItems', 'products'));
    }

    // เพิ่มสินค้าลงตะกร้า (เก็บลง Cookie)
    public function addToCart(Request $request)
    {
        // รับข้อมูลจาก Ajax
        $newItem = [
            'row_id' => uniqid(), // สร้าง ID อ้างอิงสำหรับลบ/แก้ไข
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'options' => [
                'size_name' => $request->size_name,
                'print_name' => $request->print_name,
                'part_name' => $request->part_name,
                'details_text' => $request->details_text // ข้อมูลสรุปที่จะโชว์ในกล่อง
            ]
        ];

        // ดึง Cookie เก่า
        $cookieData = $request->cookie('shopping_cart');
        $cart = $cookieData ? json_decode($cookieData, true) : [];

        // เพิ่มรายการใหม่
        $cart[] = $newItem;

        // บันทึกกลับลง Cookie (อายุ 30 วัน = 43200 นาที)
        $cookie = Cookie::make('shopping_cart', json_encode($cart), 43200);

        return response()->json(['status' => 'success', 'message' => 'เพิ่มลงตะกร้าเรียบร้อย', 'count' => count($cart)])->withCookie($cookie);
    }
    
    // ลบสินค้า (แถมให้เผื่อใช้ปุ่มถังขยะ)
    public function removeFromCart(Request $request) {
        $rowId = $request->row_id;
        $cookieData = $request->cookie('shopping_cart');
        $cart = $cookieData ? json_decode($cookieData, true) : [];
        
        // Filter เอาตัวที่ไม่ใช่ออก
        $cart = array_filter($cart, function($item) use ($rowId) {
            return $item['row_id'] != $rowId;
        });
        
        $cookie = Cookie::make('shopping_cart', json_encode($cart), 43200);
        return response()->json(['status' => 'success'])->withCookie($cookie);
    }

    public function updateCart(Request $request)
    {
        $rowId = $request->row_id;
        $cookieData = $request->cookie('shopping_cart');
        $cart = $cookieData ? json_decode($cookieData, true) : [];

        // วนลูปหา row_id ที่ตรงกัน แล้วอัปเดตข้อมูล
        foreach ($cart as &$item) {
            if ($item['row_id'] == $rowId) {
                $item['quantity'] = $request->quantity;
                $item['options']['size_name'] = $request->size_name;
                $item['options']['print_name'] = $request->print_name;
                $item['options']['part_name'] = $request->part_name;
                // ... อัปเดตอื่นๆ
                break; 
            }
        }

        $cookie = Cookie::make('shopping_cart', json_encode($cart), 43200);
        return response()->json(['status' => 'success'])->withCookie($cookie);
    }
}