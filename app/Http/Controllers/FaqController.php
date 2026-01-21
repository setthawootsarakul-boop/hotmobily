<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public function index()
    {

        $faqs = DB::table('faq_details')
            ->where('status', 1) 
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('faq', compact('faqs'));
    }
}