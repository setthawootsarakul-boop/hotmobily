<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq_details', function (Blueprint $table) {
            $table->id();
            $table->integer('faq_id')->nullable();
            $table->mediumText('question')->nullable();
            $table->mediumText('answer')->nullable();
            $table->boolean('show_product_page')->default(0);
            $table->string('faq_image_1', 255)->nullable();
            $table->string('faq_image_2', 255)->nullable();
            $table->string('created_by', 30)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_details');
    }
};
