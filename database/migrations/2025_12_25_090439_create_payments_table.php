<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');      // หมายเลขคำสั่งซื้อ
            $table->string('name');          // ชื่อ-นามสกุล
            $table->string('email');         // อีเมล
            $table->string('phone');         // เบอร์โทรศัพท์
            $table->decimal('amount', 12, 2); // ยอดเงินที่โอน
            $table->date('transfer_date');   // วันที่ทำรายการ
            $table->time('transfer_time');   // เวลาที่ทำรายการ
            $table->string('slip_path');     // เก็บพาธรูปหลักฐานการชำระเงิน
            $table->text('note')->nullable(); // ข้อความเพิ่มเติม
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending'); // สถานะตรวจสอบ
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('payments');
    }
};
