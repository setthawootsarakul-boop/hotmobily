<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review; // ✅ เพิ่มบรรทัดนี้

class HomeController extends Controller
{
    public function index()
    {
        // ดึงรีวิว 3 อันล่าสุด
        $reviews = Review::latest()->take(3)->get();

        return view('home', compact('reviews'));
    }
}