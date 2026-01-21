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
        Schema::table('product_parts', function (Blueprint $table) {
            if (!Schema::hasColumn('product_parts', 'category_part_id')) {
                $table->unsignedBigInteger('category_part_id')->nullable()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_parts', function (Blueprint $table) {
            //
        });
    }
};
