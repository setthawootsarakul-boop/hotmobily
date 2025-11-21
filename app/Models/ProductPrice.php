<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    protected $table = 'product_price'; // เพราะชื่อตารางไม่เป็นพหูพจน์
    protected $fillable = [
        'product_id',
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
