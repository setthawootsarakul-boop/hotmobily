<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'category_part_id', // 🚩 เพิ่มเพื่อเชื่อมกับหมวดหมู่ อุปกรณ์เสริม 5 กลุ่ม
        'img_url', // 🚩 ใช้คอลัมน์เดิมที่มีอยู่แล้ว
        'part_name',
        'color',
        'note',
        'option_note'
    ];

    /**
     * เชื่อมโยงกับหมวดหมู่ (Accessories Categories)
     * ใช้สำหรับหน้าอุปกรณ์เสริมในการแยกกลุ่ม ตะขอ, ฐานรอง ฯลฯ
     */
    public function category()
    {
        return $this->belongsTo(CategoryPart::class, 'category_part_id');
    }

    /**
     * ความสัมพันธ์เดิม (ห้ามลบ)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * ความสัมพันธ์กับตารางราคา (ห้ามลบ)
     */
    public function prices()
    {
        return $this->hasMany(ProductPartPrice::class, 'part_id');
    }
}