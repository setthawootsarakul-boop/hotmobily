<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // หน้านี้รองรับ filter by category slug (optional)
        $query = Product::with(['category','images','prices']);

        if ($request->filled('category')) {
            // กรองตาม category id (คุณอาจใช้ slug ก็ได้)
            $query->where('category_id', $request->category);
        }

        // (แก้ไข) เปลี่ยนจาก paginate(12) เป็น get()
        $products = $query->orderBy('name')->get();
        
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products','categories'));
    }

    // (ถ้าต้องการ) แสดงเฉพาะหมวดด้วย slug
    public function showByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::with(['category','images','prices'])
                            ->where('category_id', $category->id)
                            ->orderBy('name')
                            
                            // (แก้ไข) เปลี่ยนจาก paginate(12) เป็น get()
                            ->get();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products','categories','category'));
    }
}