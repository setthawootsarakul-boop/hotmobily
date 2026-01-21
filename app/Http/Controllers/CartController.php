<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie; // (เผื่อไว้ แต่หลักๆ ใช้ DB)
use App\Models\Product;
use App\Models\CartItem;    // ✅ เรียกใช้ Model ตะกร้าใน DB
use App\Models\ProductPart; // ✅ เรียกใช้เพื่อดึงสีอะไหล่

class CartController extends Controller
{
    // =========================================================
    // 1. แสดงหน้าตะกร้าสินค้า
    // =========================================================
    public function index(Request $request)
    {
        // 1. ดึงข้อมูลจาก Database ตาม Session ID ปัจจุบัน
        $sessionId = Session::getId();
        $cartItems = CartItem::where('session_id', $sessionId)->get();

        // 2. ดึง Product ID ทั้งหมดในตะกร้าออกมา (เฉพาะที่ไม่ซ้ำ) เพื่อไปดึงรูป/ชื่อสินค้า
        $productIds = $cartItems->pluck('product_id')->unique();

        // 3. Query ข้อมูลสินค้าจริงจาก Database
        $products = Product::with('images')
                    ->whereIn('id', $productIds)
                    ->get()
                    ->keyBy('id');

        // 4. กรองสินค้า: ตรวจสอบว่าสินค้าในตะกร้ายังมีอยู่ในระบบจริงไหม (กัน Error)
        $validCartItems = [];
        foreach ($cartItems as $item) {
            if (isset($products[$item->product_id])) {
                $validCartItems[] = $item;
            }
        }

        return view('cart', [
            'cartItems' => $validCartItems, // ส่งเป็น Array/Collection
            'products' => $products
        ]);
    }

    // =========================================================
    // 2. เพิ่มสินค้าลงตะกร้า (ลง Database)
    // =========================================================
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int)$request->input('quantity', 1);
        $sessionId = Session::getId();

        if (!$productId || $quantity < 1) {
            return response()->json(['status' => 'error', 'message' => 'ข้อมูลสินค้าไม่ถูกต้อง']);
        }

        // --- 🔥 1. ค้นหาข้อมูล Part เพื่อเอา "ชื่อ" และ "สี" 🔥 ---
        $partId = $request->input('part_id');
        $partName = '-';
        $partColor = '-';

        if ($partId) {
            $part = ProductPart::find($partId);
            if ($part) {
                $partName = $part->part_name;
                $partColor = $part->color; // ✅ ดึงสีมาด้วย
            }
        } else {
            // กรณีไม่มี part_id ส่งมา (เช่น สินค้าไม่มีอะไหล่) ให้ใช้ค่าที่ส่งมาตรงๆ
            $partName = trim($request->input('part_name', '-'));
        }

        // --- 2. เตรียมข้อมูล Options ---
        // (เรียงลำดับ Key ให้เหมือนกันเสมอ เพื่อความเป๊ะในการเปรียบเทียบ)
        $options = [
            'size_name'    => trim($request->input('size_name', '-')),
            'print_name'   => trim($request->input('print_name', '-')),
            'part_name'    => $partName,
            'part_color'   => $partColor, // ✅ บันทึกสีลง DB
            'details_text' => trim($request->input('details_text', '')),
        ];

        // --- 3. เช็คว่ามีสินค้านี้ (Option เดียวกันเป๊ะ) อยู่แล้วไหม? ---
        // เนื่องจาก Options เก็บเป็น JSON เราต้องดึงมาเช็คใน PHP
        $existingItems = CartItem::where('session_id', $sessionId)
                        ->where('product_id', $productId)
                        ->get();

        $matchItem = null;
        foreach ($existingItems as $item) {
            // เปรียบเทียบ Array Options (Laravel แปลง JSON -> Array ให้แล้วใน Model)
            if ($item->options == $options) {
                $matchItem = $item;
                break;
            }
        }

        $rowId = null;

        if ($matchItem) {
            // A. มีอยู่แล้ว -> บวกจำนวนเพิ่ม
            $matchItem->quantity += $quantity;
            $matchItem->save();
            $rowId = $matchItem->id;
        } else {
            // B. ยังไม่มี -> เช็คโควต้า 10 รายการ
            $currentCount = CartItem::where('session_id', $sessionId)->count();
            if ($currentCount >= 10) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ตะกร้าสินค้าเต็ม! (สูงสุด 10 รายการ)'
                ]);
            }

            // สร้างรายการใหม่
            $newItem = CartItem::create([
                'session_id' => $sessionId,
                'user_id'    => auth()->id(), // (ถ้ามีระบบสมาชิก)
                'product_id' => $productId,
                'quantity'   => $quantity,
                'options'    => $options
            ]);
            $rowId = $newItem->id;
        }

        // นับจำนวนรายการล่าสุดเพื่ออัปเดต Badge
        $newCount = CartItem::where('session_id', $sessionId)->count();

        return response()->json([
            'status'     => 'success',
            'message'    => 'เพิ่มลงตะกร้าเรียบร้อยแล้ว',
            'row_id'     => $rowId,
            'cart_count' => $newCount
        ]);
    }
    
    // =========================================================
    // 3. ลบสินค้าออกจากตะกร้า
    // =========================================================
    public function removeFromCart(Request $request) {
        $rowId = $request->row_id; // รับ ID ของตาราง cart_items
        
        // ลบข้อมูลใน DB
        CartItem::destroy($rowId);
        
        // นับจำนวนที่เหลือ
        $newCount = CartItem::where('session_id', Session::getId())->count();
        
        return response()->json([
            'status' => 'success',
            'cart_count' => $newCount
        ]);
    }

    // =========================================================
    // 4. อัปเดตข้อมูลในตะกร้า (แก้ไข)
    // =========================================================
    public function updateCart(Request $request)
    {
        $rowId = $request->row_id; // ID ที่จะแก้ไข
        
        // --- 1. เตรียมข้อมูล Options ใหม่ (เหมือน addToCart) ---
        $partId = $request->input('part_id');
        $partName = '-';
        $partColor = '-';

        if ($partId) {
            $part = ProductPart::find($partId);
            if ($part) {
                $partName = $part->part_name;
                $partColor = $part->color;
            }
        } else {
            $partName = trim($request->input('part_name', '-'));
        }

        $newOptions = [
            'size_name'    => trim($request->input('size_name', '-')),
            'print_name'   => trim($request->input('print_name', '-')),
            'part_name'    => $partName,
            'part_color'   => $partColor,
            'details_text' => trim($request->input('details_text', '')),
        ];
        
        // --- 2. ค้นหาและอัปเดต ---
        $item = CartItem::find($rowId);
        
        if ($item) {
            // (Optional: ถ้าต้องการเช็คว่าแก้แล้วไปซ้ำกับอันอื่นไหม สามารถเพิ่ม Logic เช็คตรงนี้ได้)
            // แต่เพื่อความง่าย เราจะอัปเดตทับรายการเดิมไปเลย
            
            $item->quantity = (int)$request->quantity;
            $item->options = $newOptions;
            $item->save();
        }

        return response()->json(['status' => 'success']);
    }
}