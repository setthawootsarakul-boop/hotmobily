<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'session_id', 'quotation_number',
        'fullname', 'phone', 'email',
        'province', 'district', 'sub_district', 'zipcode',
        'address_no', 'building', 'floor', 'moo', 'village', 'soi', 'road', 'note',
        'tax_invoice_required', 'tax_invoice_type', 'status',
        // Tax Info
        'tax_person_type', 'tax_name', 'tax_id', 
        'tax_province', 'tax_district', 'tax_sub_district', 'tax_zipcode',
        'tax_address_no', 'tax_building', 'tax_floor', 'tax_moo', 
        'tax_village', 'tax_soi', 'tax_road', 'tax_note',
        // ✅ เพิ่ม Field คำนวณเงินและวันที่ (ตาม SQL Dump)
        'subtotal', 'express_fee', 'vat_amount', 'grand_total', 'due_date'
    ];

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }
}