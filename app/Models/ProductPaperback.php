<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPaperback extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'paper_type',
        'color',
        'description'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductPaperbackPrice::class, 'paperback_id');
    }
}
