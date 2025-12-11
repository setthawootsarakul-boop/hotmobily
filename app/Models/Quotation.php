<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    /**
     * ตารางที่เกี่ยวข้องกับ Model นี้
     */
    protected $table = 'quotations';

    /**
     * รายชื่อคอลัมน์ที่อนุญาตให้บันทึกข้อมูลได้ (Mass Assignment)
     */
    protected $fillable = [
        // 1. ข้อมูลระบุตัวตน
        'user_id',
        'session_id',
        'status', // pending, confirmed, cancelled

        // 2. ข้อมูลผู้ติดต่อ
        'fullname',
        'phone',
        'email',

        // 3. ที่อยู่ในการรับสินค้า
        'province',
        'district',
        'sub_district',
        'zipcode',
        'address_no',
        'building',
        'floor',
        'moo',
        'village',
        'soi',
        'road',
        'note', // ข้อความเพิ่มเติม

        // 4. สถานะใบกำกับภาษี
        'tax_invoice_required', // boolean (0, 1)
        'tax_invoice_type',     // paper, etax

        // 5. ข้อมูลใบกำกับภาษี (สำหรับ Step 2)
        'tax_person_type', // individual, juristic
        'tax_name',        // ชื่อ-นามสกุล หรือ ชื่อบริษัท
        'tax_id',          // เลขประจำตัวผู้เสียภาษี
        
        // 6. ที่อยู่ในใบกำกับภาษี
        'tax_province',
        'tax_district',
        'tax_sub_district',
        'tax_zipcode',
        'tax_address_no',
        'tax_building',
        'tax_floor',
        'tax_moo',
        'tax_village',
        'tax_soi',
        'tax_road',
        'tax_note'
    ];

    /**
     * แปลงประเภทข้อมูลอัตโนมัติ
     */
    protected $casts = [
        'tax_invoice_required' => 'boolean',
    ];

    /**
     * ความสัมพันธ์กับ User (ถ้ามีระบบสมาชิก)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}