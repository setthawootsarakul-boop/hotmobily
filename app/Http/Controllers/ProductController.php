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

public function calculatePrice(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'size_id' => 'required',
            'printing_id' => 'required',
            'part_id' => 'nullable' // อาจจะไม่เลือกอะไหล่ก็ได้
        ]);

        $qty = $request->quantity;

        // 1. หา "ราคาต่อชิ้น" จากตาราง product_price (Tier Price)
        // โดยดูว่า Quantity ที่ลูกค้ากรอก ตรงกับช่วงไหน (Min - Max)
        $priceTier = \DB::table('product_price')
            ->where('product_id', $request->product_id)
            ->where('product_size_id', $request->size_id)
            ->where('product_printing_id', $request->printing_id)
            ->where('quantity_min', '<=', $qty)
            ->where('quantity_max', '>=', $qty)
            ->first();

        // ถ้าไม่เจอช่วงราคา (เช่น สั่งเยอะเกิน Max) ให้ใช้ราคาของขั้นบันไดสูงสุดที่มี
        if (!$priceTier) {
            $priceTier = \DB::table('product_price')
                ->where('product_id', $request->product_id)
                ->where('product_size_id', $request->size_id)
                ->where('product_printing_id', $request->printing_id)
                ->orderBy('quantity_min', 'desc')
                ->first();
        }

        $basePricePerUnit = $priceTier ? $priceTier->price_per_unit : 0;

        // 2. ราคาอะไหล่เพิ่ม (Extra Part Price)
        $partPrice = 0;
        $partInfo = null;
        if ($request->part_id) {
            $part = \App\Models\ProductPart::find($request->part_id);
            if ($part) {
                $partPrice = $part->price_extra;
                $partInfo = [
                    'name' => $part->part_name,
                    'image' => $part->image_url ? asset($part->image_url) : null
                ];
            }
        }

        // 3. คำนวณยอดรวม
        // ราคาสินค้าทั้งล็อต = ราคาต่อชิ้น * จำนวน
        $totalProductPrice = $basePricePerUnit * $qty; 
        
        // ราคาอะไหล่ทั้งล็อต = ราคาอะไหล่ต่อชิ้น * จำนวน
        $totalPartPrice = $partPrice * $qty;

        // ราคาก่อน VAT
        $subtotal = $totalProductPrice + $totalPartPrice;

        // VAT 7%
        $vat = $subtotal * 0.07;

        // ราคาสุทธิ
        $grandTotal = $subtotal + $vat;

        // ดึงข้อมูลชื่อเพื่อส่งกลับไปแสดงผล
        $sizeName = \App\Models\ProductSize::find($request->size_id)->size_name ?? '-';
        $printName = \App\Models\ProductPrinting::find($request->printing_id)->printing_type ?? '-';

        return response()->json([
            'status' => 'success',
            'data' => [
                'size_name' => $sizeName,
                'print_name' => $printName,
                'part_info' => $partInfo,
                'quantity' => number_format($qty),
                'total_product_price' => number_format($totalProductPrice, 2), // ราคาสินค้า (รวมตามจำนวน)
                'total_part_price' => number_format($totalPartPrice, 2),       // ส่วนประกอบ (รวมตามจำนวน)
                'subtotal' => number_format($subtotal, 2), // ราคาก่อนรวมภาษี
                'vat' => number_format($vat, 2),           // ภาษี
                'grand_total' => number_format($grandTotal, 2) // ราคาประเมินรวม
            ]
        ]);
    }
}