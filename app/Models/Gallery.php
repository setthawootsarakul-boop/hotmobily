<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    // กำหนดชื่อตาราง (หากคุณใช้ชื่อ galleries ตาม migration ไม่ต้องใส่ก็ได้ครับ)
    protected $table = 'galleries';

    // อนุญาตให้บันทึกข้อมูลในฟิลด์เหล่านี้ได้
    protected $fillable = [
        'category_id', 
        'title', 
        'image_path', 
        'sort_order'
    ];

    /**
     * ความสัมพันธ์: ผลงานนี้เป็นของหมวดหมู่ใด (Many to One)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}