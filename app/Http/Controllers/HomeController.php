<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review; 

class HomeController extends Controller
{
    public function index()
    {
        // ✅ ดึงข้อมูลรีวิวทั้งหมดจากฐานข้อมูล (เรียงจากใหม่สุด)
        $reviews = Review::orderBy('created_at', 'desc')->get();

        // ✅ ส่งตัวแปร $reviews ไปที่หน้า home
        return view('home', compact('reviews'));
    }
}