<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrinting extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'printing_type',
        'color_type',
        'note'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
