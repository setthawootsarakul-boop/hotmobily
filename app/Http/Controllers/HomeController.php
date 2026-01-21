<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review; 
use Illuminate\Support\Facades\Http; // ✅ เพิ่มตัวนี้เพื่อดึง API

class HomeController extends Controller
{
    public function index()
    {
        try {
            $response = Http::get('https://hotstrapthai.com/api/get-banner.php', [
                'mkey' => 'HM@2025'
            ]);
            $banners = $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            \Log::error("API Banner Error: " . $e->getMessage());
            $banners = [];
        }

        // 2. ดึงข้อมูลรีวิวจากฐานข้อมูล (โค้ดเดิมของคุณ)
        $reviews = Review::orderBy('created_at', 'desc')->get();

        // dd($banners);
        return view('home', compact('banners', 'reviews'));
    }
}