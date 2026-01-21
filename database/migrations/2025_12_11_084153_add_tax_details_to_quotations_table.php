<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            // ข้อมูลใบกำกับภาษี
            $table->string('tax_person_type')->nullable()->comment('ประเภท: individual (บุคคล), juristic (นิติบุคคล)');
            $table->string('tax_name')->nullable()->comment('ชื่อ-นามสกุล หรือ ชื่อบริษัท');
            $table->string('tax_id')->nullable()->comment('เลขประจำตัวผู้เสียภาษี');
            
            // ที่อยู่ใบกำกับภาษี
            $table->string('tax_province')->nullable();
            $table->string('tax_district')->nullable();
            $table->string('tax_sub_district')->nullable();
            $table->string('tax_zipcode')->nullable();
            
            // รายละเอียดที่อยู่ภาษี
            $table->string('tax_address_no')->nullable();
            $table->string('tax_building')->nullable();
            $table->string('tax_floor')->nullable();
            $table->string('tax_moo')->nullable();
            $table->string('tax_village')->nullable();
            $table->string('tax_soi')->nullable();
            $table->string('tax_road')->nullable();
            
            $table->text('tax_note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn([
                'tax_person_type', 'tax_name', 'tax_id',
                'tax_province', 'tax_district', 'tax_sub_district', 'tax_zipcode',
                'tax_address_no', 'tax_building', 'tax_floor', 'tax_moo', 
                'tax_village', 'tax_soi', 'tax_road', 'tax_note'
            ]);
        });
    }
};