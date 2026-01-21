<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname', 'company_name', 'phone', 'email', 'province', 'district', 
        'sub_district', 'zipcode', 'address_no', 'building', 'floor', 'moo', 
        'village', 'soi', 'road', 'note', 'tax_invoice_required', 'tax_person_type', 
        'tax_name', 'tax_company', 'tax_id', 'tax_province', 'tax_district', 
        'tax_sub_district', 'tax_zipcode', 'tax_address_no', 'tax_building', 
        'tax_floor', 'tax_moo', 'tax_village', 'tax_soi', 'tax_road', 'tax_note',
        'subtotal', 'grand_total', 'quotation_number', 'status', 'due_date', 'session_id', 'user_id',
        'attachments'
    ];

    // ✅ 2. เพิ่มส่วนนี้เพื่อให้ระบบแปลงค่า Array เป็น JSON ลง Database ให้อัตโนมัติ (เหมือนหน้า Contact)
    protected $casts = [
        'attachments' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }
}