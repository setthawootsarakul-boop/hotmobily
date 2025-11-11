<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category','images','prices']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('material')) {
            $query->where('base_material', $request->material);
        }

        // 
        // ✅ (แก้ไข) เปลี่ยนจาก orderBy('name') เป็น orderBy('rank')
        // (เราเพิ่ม 'name' เป็นตัวสำรอง เผื่อว่า rank ซ้ำกัน)
        // 
        $products = $query->orderBy('rank', 'asc')->orderBy('name', 'asc')->get();
        
        // 
        // ✅ (แก้ไข) เปลี่ยนจาก orderBy('name') เป็น orderBy('rank')
        // 
        $categories = Category::orderBy('rank', 'asc')->orderBy('name', 'asc')->get();

        return view('products.index', compact('products','categories'));
    }

    // (ถ้าต้องการ) แสดงเฉพาะหมวดด้วย slug
    public function showByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // 
        // ✅ (แก้ไข) เปลี่ยนจาก orderBy('name') เป็น orderBy('rank')
        // 
        $products = Product::with(['category','images','prices'])
                            ->where('category_id', $category->id)
                            ->orderBy('rank', 'asc')->orderBy('name', 'asc')
                            ->get();

        // 
        // ✅ (แก้ไข) เปลี่ยนจาก orderBy('name') เป็น orderBy('rank')
        // 
        $categories = Category::orderBy('rank', 'asc')->orderBy('name', 'asc')->get();

        return view('products.index', compact('products','categories','category'));
    }
}