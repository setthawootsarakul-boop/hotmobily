<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 1. หน้าสินค้าทั้งหมด (Index) - เหมือนเดิม
    public function index(Request $request)
    {
        $query = Product::with(['category','images','prices']);
        $pageTitle = 'สินค้าทั้งหมด';

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
            $categoryName = Category::where('id', $request->category)->value('name');
            if ($categoryName) $pageTitle = $categoryName;
        }

        if ($request->filled('material')) {
            $query->where('base_material', $request->material);
            $pageTitle = $request->material;
        }

        $products = $query->orderBy('rank', 'asc')->orderBy('name', 'asc')->get();
        $categories = Category::orderBy('rank', 'asc')->orderBy('name', 'asc')->get();

        return view('products.index', compact('products', 'categories', 'pageTitle'));
    }

    // 2. หน้าหมวดหมู่ (Category) - เหมือนเดิม
    public function showByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $products = Product::with(['category','images','prices'])
                            ->where('category_id', $category->id)
                            ->orderBy('rank', 'asc')->orderBy('name', 'asc')
                            ->get();

        $categories = Category::orderBy('rank', 'asc')->orderBy('name', 'asc')->get();
        $pageTitle = $category->name;

        return view('products.index', compact('products', 'categories', 'category', 'pageTitle'));
    }

    // ✅✅✅ 3. เพิ่มหน้ารายละเอียดสินค้า (Product Detail) ✅✅✅
// app/Http/Controllers/ProductController.php

public function show($slug)
    {
        // 1. ดึงข้อมูลสินค้าพร้อมความสัมพันธ์ทั้งหมด
        $product = Product::where('slug', $slug)
                    ->with([
                        // เรียงลำดับรูปภาพ (ถ้าระบุ sort_order)
                        'images' => function($q) { $q->orderBy('sort_order', 'asc'); },
                        'sizes',
                        'prices',
                        'parts',
                        'printings',
                        'paperbacks',
                        'materials', // อย่าลืม Model นี้ถ้ามี
                        'category'
                    ])
                    ->firstOrFail();

        // 2. เตรียมข้อมูลสำหรับ "ตารางราคา" (Matrix)
        // ดึงเลขจำนวนขั้นบันไดทั้งหมดที่มี (เช่น 1, 50, 100) มาเพื่อสร้างแถวตาราง
        $quantities = $product->prices
                        ->unique('quantity_min')
                        ->sortBy('quantity_min')
                        ->pluck('quantity_min');

        // 3. สินค้าที่เกี่ยวข้อง (สุ่มมา 4 ชิ้น)
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->inRandomOrder()
                                  ->take(4)
                                  ->get();

        return view('products.show', compact('product', 'quantities', 'relatedProducts'));
    }
}