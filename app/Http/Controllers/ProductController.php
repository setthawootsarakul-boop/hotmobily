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

        // ตั้งค่าชื่อหน้าเริ่มต้น
        $pageTitle = 'สินค้าทั้งหมด';

        // 1. กรองตาม Category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
            
            // หาชื่อหมวดหมู่มาใส่ใน Title
            $categoryName = Category::where('id', $request->category)->value('name');
            if ($categoryName) {
                $pageTitle = $categoryName;
            }
        }

        // 2. กรองตาม Material
        if ($request->filled('material')) {
            $query->where('base_material', $request->material);
            // เอาชื่อวัสดุมาใส่ใน Title
            $pageTitle = $request->material;
        }

        $products = $query->orderBy('rank', 'asc')->orderBy('name', 'asc')->get();
        $categories = Category::orderBy('rank', 'asc')->orderBy('name', 'asc')->get();

        // ส่งตัวแปร $pageTitle ไปที่ View ด้วย
        return view('products.index', compact('products', 'categories', 'pageTitle'));
    }

    public function showByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $products = Product::with(['category','images','prices'])
                            ->where('category_id', $category->id)
                            ->orderBy('rank', 'asc')->orderBy('name', 'asc')
                            ->get();

        $categories = Category::orderBy('rank', 'asc')->orderBy('name', 'asc')->get();
        
        // กรณีใช้ Route นี้ ชื่อหน้าคือชื่อหมวดหมู่
        $pageTitle = $category->name;

        return view('products.index', compact('products', 'categories', 'category', 'pageTitle'));
    }
}