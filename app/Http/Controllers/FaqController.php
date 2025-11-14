<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public function index()
    {
        // ✅ ดึงข้อมูล FAQ จากฐานข้อมูลด้วย Query Builder
        $faqs = DB::table('faq_details')
            ->orderBy('created_at', 'asc')
            ->paginate(5);

        // dd($faqs); // ตรวจสอบข้อมูลที่ดึงมาได้
            // ✅ ส่งข้อมูลทั้งหมดไปยังหน้า view: faq.blade.php
        return view('faq', compact('faqs'));
        
    }
}
