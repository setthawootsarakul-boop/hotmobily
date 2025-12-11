<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            
            // ส่วนระบุตัวตน (รองรับทั้งสมาชิกและ Guest)
            $table->unsignedBigInteger('user_id')->nullable()->comment('เก็บ ID กรณีเป็นสมาชิก');
            $table->string('session_id')->nullable()->comment('เก็บ Session ID กรณี Guest');
            
            // ข้อมูลผู้ติดต่อ
            $table->string('fullname')->comment('ชื่อ-นามสกุล');
            $table->string('phone', 20)->comment('เบอร์โทรศัพท์');
            $table->string('email')->comment('อีเมล');

            // ที่อยู่จัดส่ง (Dropdowns)
            $table->string('province')->comment('จังหวัด');
            $table->string('district')->comment('อำเภอ/เขต');
            $table->string('sub_district')->comment('ตำบล/แขวง');
            $table->string('zipcode', 10)->comment('รหัสไปรษณีย์');

            // ที่อยู่รายละเอียด
            $table->string('address_no')->nullable()->comment('เลขที่');
            $table->string('building')->nullable()->comment('ชื่ออาคาร');
            $table->string('floor')->nullable()->comment('ชั้นที่');
            $table->string('moo')->nullable()->comment('หมู่');
            $table->string('village')->nullable()->comment('หมู่บ้าน');
            $table->string('soi')->nullable()->comment('ซอย');
            $table->string('road')->nullable()->comment('ถนน');

            $table->text('note')->nullable()->comment('ข้อความเพิ่มเติม');

            // ข้อมูลใบกำกับภาษี
            $table->boolean('tax_invoice_required')->default(false)->comment('ต้องการใบกำกับภาษีหรือไม่');
            $table->string('tax_invoice_type')->nullable()->comment('ประเภทใบกำกับภาษี (paper/etax)');

            // สถานะใบเสนอราคา
            $table->string('status')->default('pending')->comment('สถานะ: pending, confirmed, cancelled');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};