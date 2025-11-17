<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // เพิ่มบรรทัดนี้เพื่อใช้ Insert ข้อมูลตัวอย่าง

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. สร้างตาราง
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('product_rating')->comment('คะแนนสินค้า (1-5)');
            $table->integer('service_rating')->comment('คะแนนบริการ (1-5)');
            $table->text('comment')->comment('ความคิดเห็น');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};