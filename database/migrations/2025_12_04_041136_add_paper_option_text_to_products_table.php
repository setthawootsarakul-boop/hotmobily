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
            // ✅ เพิ่มคอลัมน์ paper_option_text
            // ใช้ประเภท text เพราะข้อความอาจจะยาว
            // nullable() สำคัญมาก! เพราะสินค้าชิ้นอื่นจะไม่มีค่านี้
            // after('special_features') เพื่อจัดเรียงให้สวยงามใน Database
            $table->text('paper_option_text')->nullable()->after('special_features');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // ✅ คำสั่งลบคอลัมน์หากมีการ Rollback
            $table->dropColumn('paper_option_text');
        });
    }
};