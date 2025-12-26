<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller {
    public function store(Request $request) {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ], [
            'email.unique' => 'อีเมลนี้ได้สมัครสมาชิกไปเรียบร้อยแล้ว'
        ]);

        Newsletter::create(['email' => $request->email]);

        return back()->with('subscribe_success', 'ขอบคุณที่สมัครรับข่าวสารจากเรา!');
    }
}