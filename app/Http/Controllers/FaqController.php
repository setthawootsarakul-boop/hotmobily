<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        // ส่งไปยังหน้า view ชื่อว่า faq.blade.php
        return view('faq');
    }
}
