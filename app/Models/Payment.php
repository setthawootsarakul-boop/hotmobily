<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    // กำหนดฟิลด์ที่อนุญาตให้บันทึกข้อมูลได้
    protected $fillable = [
        'order_id', 'name', 'email', 'phone', 
        'amount', 'transfer_date', 'transfer_time', 
        'slip_path', 'note', 'status'
    ];
}