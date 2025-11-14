<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPartPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_id',
        'quantity_min',
        'quantity_max',
        'price_per_unit'
    ];

    public function part()
    {
        return $this->belongsTo(ProductPart::class, 'part_id');
    }
}
