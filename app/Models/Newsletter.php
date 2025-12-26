<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Newsletter extends Model
{
    use HasFactory;

    // กำหนดชื่อตาราง (กรณีชื่อตารางในฐานข้อมูลเป็นตัวพหูพจน์ newsletters ระบบจะหาเจออัตโนมัติ)
    protected $table = 'newsletters';

    // อนุญาตให้บันทึกข้อมูลฟิลด์ email ลงในฐานข้อมูลได้
    protected $fillable = [
        'email',
    ];
}