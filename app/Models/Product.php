<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'category_id', 
        'base_material', 
        'rank',
        'status',            // ✅ เพิ่มสถานะ เปิด-ปิด
        'moq',               // ✅ เพิ่มจำนวนสั่งขั้นต่ำ
        'packing',           // ✅ เพิ่มการบรรจุ
        'production_time',   // ✅ เพิ่มระยะเวลาผลิต
        'free_sample_text',  // ✅ เพิ่มข้อความตัวอย่างสินค้า
        'special_features',  // ✅ เพิ่มคุณสมบัติพิเศษ
        'custom_fields'      // ✅ เพิ่มข้อมูลเพิ่มเติม (JSON)
    ];

    public function getRouteKeyName() { return 'slug'; }
    public function category() { return $this->belongsTo(Category::class); }
    public function images() { return $this->hasMany(ProductImage::class); }
    public function sizes() { return $this->hasMany(ProductSize::class); }
    public function printings() { return $this->hasMany(ProductPrinting::class); }
    public function parts() { return $this->hasMany(ProductPart::class); }
    public function paperbacks() { return $this->hasMany(ProductPaperback::class); }
    public function materials() { return $this->hasMany(ProductMaterial::class); }
    public function prices() { return $this->hasMany(ProductPrice::class); }
}