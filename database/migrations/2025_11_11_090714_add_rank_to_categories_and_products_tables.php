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
        // เพิ่มคอลัมน์ rank ในตาราง categories
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('rank')->default(null)->after('description');
        });

        // เพิ่มคอลัมน์ rank ในตาราง products
        Schema::table('products', function (Blueprint $table) {
            $table->integer('rank')->default(null)->after('base_material');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // (สำหรับย้อนกลับ) ลบคอลัมน์ rank ออก
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('rank');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('rank');
        });
    }
};