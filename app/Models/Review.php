<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    
    // กำหนดฟิลด์ที่อนุญาตให้เพิ่มข้อมูลได้ (เผื่ออนาคตทำระบบเพิ่มรีวิว)
    protected $fillable = [
        'product_rating',
        'service_rating',
        'comment'
    ];
}