<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // เพิ่มคอลัมน์ ความหนา และ การพิมพ์ด้านหลัง
            // วางไว้หลัง paper_option_text เพื่อความเป็นระเบียบ
            $table->string('thickness_option')->nullable()->comment('ระบุความหนา เช่น 3 มม. หรือ 5 มม.')->after('paper_option_text');
            $table->text('backside_printing_text')->nullable()->comment('ข้อมูลการพิมพ์ด้านหลัง')->after('thickness_option');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['thickness_option', 'backside_printing_text']);
        });
    }
};