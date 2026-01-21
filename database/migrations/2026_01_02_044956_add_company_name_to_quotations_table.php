<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            // เพิ่มช่อง company_name ไว้หลัง fullname และอนุญาตให้เป็น null ได้ (เผื่อกรณีบุคคลธรรมดา)
            $table->string('company_name')->nullable()->after('fullname');
        });
    }

    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('company_name');
        });
    }
};
