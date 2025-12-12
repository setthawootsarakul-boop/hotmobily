<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;

    protected $table = 'quotation_items';

    protected $fillable = [
        'quotation_id',
        'product_id',
        'product_name',
        'options',
        'quantity',
        'price_per_unit',
        'total_price',
    ];

    // ✅ สำคัญ: แปลง JSON ใน Database ให้เป็น Array อัตโนมัติเมื่อดึงมาใช้
    protected $casts = [
        'options' => 'array',
    ];

    // ความสัมพันธ์กลับไปหา Quotation (Head)
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    // ความสัมพันธ์ไปหาสินค้า (เพื่อดึงรูปภาพ)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}