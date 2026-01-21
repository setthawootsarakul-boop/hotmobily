<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'subjects', 'attachments', 'message'
    ];

    protected $casts = [
        'subjects' => 'array',
        'attachments' => 'array',
    ];
    
    /**
     * ปรับแต่งการบันทึก JSON ให้สะอาดที่สุด
     */
    protected function asJson($value, $flags = 0)
    {
        // ใช้ค่าที่เราต้องการโดยตรง: 
        // JSON_UNESCAPED_UNICODE = ภาษาไทยอ่านออก
        // JSON_UNESCAPED_SLASHES = ไม่มีเครื่องหมาย \ ใน Path ของไฟล์
        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}