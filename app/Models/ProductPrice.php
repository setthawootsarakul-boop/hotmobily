<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;
    
    // ✅ ต้องระบุ เพราะใน SQL Dump ชื่อตารางเป็นเอกพจน์
    protected $table = 'product_price'; 

    protected $fillable = [
        'product_id',
        'product_size_id',      // ✅ ต้องมี เพื่อใช้ค้นหาราคาตามขนาด
        'product_printing_id',  // ✅ ต้องมี เพื่อใช้ค้นหาราคาตามงานพิมพ์
        'quantity_min',
        'quantity_max',
        'price_per_unit',
        'note'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
