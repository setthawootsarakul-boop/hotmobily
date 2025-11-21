<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_price', function (Blueprint $table) {
            // เพิ่มคอลัมน์นี้เพื่อระบุว่าราคาเป็นของสกรีนแบบไหน
            $table->unsignedBigInteger('product_printing_id')->nullable()->after('product_size_id');

            // (Optional) สร้าง Foreign Key ถ้าต้องการ (แนะนำ)
            // $table->foreign('product_printing_id')->references('id')->on('product_printings')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('product_price', function (Blueprint $table) {
            // (Optional) $table->dropForeign(['product_printing_id']);
            $table->dropColumn('product_printing_id');
        });
    }
};