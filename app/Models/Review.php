<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // กำหนดชื่อตาราง (Optional: Laravel จะรู้เองว่าเป็น reviews แต่ใส่ไว้ก็ชัดเจนดี)
    protected $table = 'reviews';

    // กำหนดฟิลด์ที่อนุญาตให้เพิ่มข้อมูลได้ (Mass Assignment)
    protected $fillable = [
        'product_rating', // คะแนนสินค้า
        'service_rating', // คะแนนบริการ
        'comment',        // ความคิดเห็น
    ];

    // (Optional) ถ้าคุณต้องการจัดการรูปแบบวันที่ให้เป็นภาษาไทย หรือ Format อื่นๆ
    // protected $casts = [
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',
    // ];
}