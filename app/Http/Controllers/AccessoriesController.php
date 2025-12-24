<?php

namespace App\Http\Controllers;

use App\Models\ProductPart;
use Illuminate\Http\Request;

class AccessoriesController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลแยกตาม category_part_id ที่เรากำหนดไว้ 1-5
        // ใช้ eager loading (with) เพื่อประสิทธิภาพที่ดีขึ้น
        $standardHooks = ProductPart::where('category_part_id', 1)->get();
        $otherHooks    = ProductPart::where('category_part_id', 2)->get();
        $standeeBases  = ProductPart::where('category_part_id', 3)->get();
        $clips         = ProductPart::where('category_part_id', 4)->get();
        $otherParts    = ProductPart::where('category_part_id', 5)->get();

        // ส่งข้อมูลทั้งหมดไปยังหน้า Blade
        return view('accessories', compact(
            'standardHooks', 
            'otherHooks', 
            'standeeBases', 
            'clips', 
            'otherParts'
        ));
    }
}