<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            
            // ข้อมูลผู้ติดต่อ (จาก input name, email, phone)
            $table->string('name')->comment('ชื่อ-นามสกุล');
            $table->string('email')->comment('อีเมล');
            $table->string('phone')->comment('เบอร์โทรศัพท์');
            
            // เรื่องที่ต้องการติดต่อ (จาก checkbox subjects[])
            // เก็บเป็น JSON เพื่อรองรับการเลือกหลายข้อพร้อมกัน
            $table->json('subjects')->nullable()->comment('หัวข้อที่เลือก');
            
            // ข้อมูลไฟล์แนบ (จาก input attachment[])
            // เก็บเป็น JSON เพื่อบันทึก Path ของหลายไฟล์ในคอลัมน์เดียว
            $table->json('attachments')->nullable()->comment('รายการไฟล์แนบทั้งหมด');
            
            // ข้อความเพิ่มเติม (จาก textarea message)
            $table->text('message')->nullable()->comment('รายละเอียดข้อความ');
            
            // สถานะสำหรับการจัดการหลังบ้าน
            $table->string('status')->default('unread')->comment('สถานะการอ่าน: unread, read, replied');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};