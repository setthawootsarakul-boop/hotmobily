<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPartPrice extends Model
{
    protected $table = 'product_part_prices';

    protected $fillable = [
        'part_id',
        'quantity_min',
        'quantity_max',
        'price_per_unit'
    ];

    // เชื่อมกลับไปหาตัวอุปกรณ์หลัก
    public function part()
    {
        return $this->belongsTo(ProductPart::class, 'part_id');
    }
}