<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('quotations', function (Blueprint $column) {
            // เพิ่มช่องเก็บชื่อบริษัท ต่อท้าย tax_name
            $column->string('tax_company')->nullable()->after('tax_name')->comment('ชื่อบริษัท/นิติบุคคล');
        });
    }

    public function down()
    {
        Schema::table('quotations', function (Blueprint $column) {
            $column->dropColumn('tax_company');
        });
    }
};