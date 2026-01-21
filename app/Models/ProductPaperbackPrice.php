<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPaperbackPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'paperback_id',
        'quantity_min',
        'quantity_max',
        'price_per_unit'
    ];

    public function paperback()
    {
        return $this->belongsTo(ProductPaperback::class, 'paperback_id');
    }
}
