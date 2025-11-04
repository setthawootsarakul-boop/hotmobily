<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        // ถ้ามีฟอร์มติดต่อในอนาคต
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:500',
        ]);

        // ตัวอย่าง: ส่งอีเมลหรือบันทึกฐานข้อมูล
        // Mail::to('hotmobily@example.com')->send(new ContactMail($validated));

        return back()->with('success', 'ส่งข้อความสำเร็จแล้วครับ');
    }
}