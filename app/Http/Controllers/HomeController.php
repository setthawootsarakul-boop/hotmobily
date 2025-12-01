<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review; // ✅ 1. เรียกใช้ Model

class HomeController extends Controller
{
    public function index()
    {
        // ✅ 2. ดึงข้อมูลรีวิวทั้งหมดจากฐานข้อมูล (เรียงจากใหม่สุด)
        $reviews = Review::orderBy('created_at', 'desc')->get();

        // ✅ 3. ส่งตัวแปร $reviews ไปที่หน้า home
        return view('home', compact('reviews'));
    }
}