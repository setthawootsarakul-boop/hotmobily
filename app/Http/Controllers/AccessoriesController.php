<?php

namespace App\Http\Controllers;

use App\Models\ProductPart;
use Illuminate\Http\Request;

class AccessoriesController extends Controller
{
    public function index()
    {
        return view('accessories', [
            // เปลี่ยนมาใช้ unique จาก image_url เพื่อให้ดึงมาครบทุกสี
            'standardHooks' => ProductPart::where('category_part_id', 1)->get()->unique('image_url'),
            'otherHooks'    => ProductPart::where('category_part_id', 2)->get()->unique('image_url'),
            'standeeBases'  => ProductPart::where('category_part_id', 3)->get()->unique('image_url'),
            'clips'         => ProductPart::where('category_part_id', 4)->get()->unique('image_url'),
            'otherParts'    => ProductPart::where('category_part_id', 5)->get()->unique('image_url'),
        ]);
    }
}