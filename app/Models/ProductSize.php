<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size_name',
        'width_mm',
        'height_mm',
        'note'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
