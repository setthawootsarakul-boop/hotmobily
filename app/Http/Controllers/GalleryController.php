<?php

namespace App\Http\Controllers;

use App\Models\Gallery; // เรียกใช้ Model Gallery ที่สร้างใหม่
use App\Models\Category; // เรียกใช้ Model Category เพื่อดึงชื่อหมวดหมู่
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    public function index(Request $request)
    {
        // ดึงรายชื่อสินค้าทั้งหมดมาทำเป็นปุ่ม (เช่น พวงกุญแจอะคริลิค, พวงกุญแจยาง)
        $products_list = \App\Models\Product::orderBy('rank', 'asc')->get();

        $query = \App\Models\Gallery::query();

        // กรองตาม product_id
        if ($request->filled('product')) {
            $query->where('product_id', $request->product);
        }

        $galleries = $query->orderBy('sort_order', 'asc')->paginate(16);

        return view('gallery', compact('galleries', 'products_list'));
    }
}