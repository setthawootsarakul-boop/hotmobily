<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            // ผูกกับใบเสนอราคา
            $table->foreignId('quotation_id')->constrained('quotations')->onDelete('cascade');
            
            // ผูกกับสินค้า (เผื่อดึงรูปภาพ)
            $table->foreignId('product_id')->constrained('products');
            
            // Snapshot ข้อมูลสินค้า (กันข้อมูลหลักเปลี่ยน)
            $table->string('product_name'); 
            
            // เก็บ Option ที่เลือก (JSON) เช่น size, parts, screen, files
            $table->json('options')->nullable();
            
            // ข้อมูลราคาและจำนวน
            $table->integer('quantity');
            $table->decimal('price_per_unit', 10, 2)->comment('ราคาต่อหน่วย ณ ตอนสั่ง');
            $table->decimal('total_price', 10, 2)->comment('ราคารวม (qty * price)');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
    }
};