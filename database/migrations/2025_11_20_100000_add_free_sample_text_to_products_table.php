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
        Schema::table('products', function (Blueprint $table) {
            // เพิ่มคอลัมน์ free_sample_text ต่อจากคอลัมน์ special_features
            // ใช้ประเภท text และอนุญาตให้เป็น null ได้ (nullable)
            $table->text('free_sample_text')->nullable()->after('special_features');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // ลบคอลัมน์ออกเมื่อ rollback
            $table->dropColumn('free_sample_text');
        });
    }
};