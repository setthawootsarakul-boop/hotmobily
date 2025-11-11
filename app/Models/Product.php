<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'category_id', 'base_material'
    ];

    public function category() { return $this->belongsTo(Category::class); }
    public function images() { return $this->hasMany(ProductImage::class); }
    public function sizes() { return $this->hasMany(ProductSize::class); }
    public function printings() { return $this->hasMany(ProductPrinting::class); }
    public function parts() { return $this->hasMany(ProductPart::class); }
    public function paperbacks() { return $this->hasMany(ProductPaperback::class); }
    public function materials() { return $this->hasMany(ProductMaterial::class); }
    public function prices() { return $this->hasMany(ProductPrice::class); }
}
