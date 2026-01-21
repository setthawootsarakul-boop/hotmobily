<?php

namespace App\Http\Controllers;

use App\Models\Gallery; 
use App\Models\Category; 
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    public function index(Request $request)
    {
        $products_list = \App\Models\Product::orderBy('rank', 'asc')->get();

        $query = \App\Models\Gallery::query();

        // กรองตาม product_id
        if ($request->filled('product')) {
            $query->where('product_id', $request->product);
        }

        $galleries = $query->orderBy('sort_order', 'asc')->paginate(16);

        return view('gallery', compact('galleries', 'products_list'));
    }
}