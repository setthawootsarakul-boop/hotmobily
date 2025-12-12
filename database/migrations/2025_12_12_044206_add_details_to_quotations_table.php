<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('quotations', function (Blueprint $table) {
            // ยอดเงินต่างๆ
            $table->decimal('subtotal', 10, 2)->default(0)->after('status');
            $table->decimal('express_fee', 10, 2)->default(0)->after('subtotal'); // ค่าเร่งด่วน
            $table->decimal('vat_amount', 10, 2)->default(0)->after('express_fee');
            $table->decimal('grand_total', 10, 2)->default(0)->after('vat_amount'); // Balance Due
            
            // วันที่
            $table->date('due_date')->nullable()->after('created_at'); // วันครบกำหนดชำระ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            //
        });
    }
};
