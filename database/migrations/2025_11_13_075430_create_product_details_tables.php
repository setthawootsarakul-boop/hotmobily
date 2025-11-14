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
        // 1. แก้ไขตาราง products (เพิ่มข้อมูลทั่วไป)
        Schema::table('products', function (Blueprint $table) {
            $table->string('moq')->nullable()->default('1 ชิ้น')->comment('ขั้นต่ำการสั่งซื้อ');
            $table->string('packing')->nullable()->default('บรรจุแยกชิ้น')->comment('รูปแบบการแพ็ค');
            $table->string('production_time')->nullable()->default('14 - 18 วันทำการ')->comment('ระยะเวลาผลิต');
            $table->text('special_features')->nullable()->comment('คุณสมบัติพิเศษ (HTML)');
        });

        // 2. แก้ไขตาราง product_images (เพิ่มรูปหลัก/ย่อย)
        Schema::table('product_images', function (Blueprint $table) {
            $table->boolean('is_main')->default(0)->after('alt_text')->comment('1=รูปหลัก, 0=รูปย่อย');
            $table->integer('sort_order')->default(0)->after('is_main')->comment('ลำดับการแสดงผล');
        });

        // 3. แก้ไขตาราง product_price (เพิ่มราคาตามไซส์)
        Schema::table('product_price', function (Blueprint $table) {
            $table->unsignedBigInteger('product_size_id')->nullable()->after('product_id')->comment('เชื่อมกับตาราง sizes');
            
            // (Optional) ถ้าต้องการ Foreign Key ให้ uncomment บรรทัดนี้
            // $table->foreign('product_size_id')->references('id')->on('product_sizes')->onDelete('cascade');
        });

        // 4. แก้ไขตาราง product_parts (เพิ่มรูปและราคาอะไหล่)
        Schema::table('product_parts', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('color')->comment('รูปไอคอนอะไหล่');
            $table->decimal('price_extra', 10, 2)->default(0.00)->after('image_url')->comment('ราคาบวกเพิ่ม');
            $table->boolean('is_default')->default(0)->after('price_extra')->comment('เป็นค่าเริ่มต้นหรือไม่');
        });

        // 5. แก้ไขตาราง product_printings (เพิ่มราคาค่าสกรีน)
        Schema::table('product_printings', function (Blueprint $table) {
            $table->decimal('price_extra', 10, 2)->default(0.00)->after('note')->comment('ราคาบวกเพิ่ม');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 5. ลบคอลัมน์จาก product_printings
        Schema::table('product_printings', function (Blueprint $table) {
            $table->dropColumn(['price_extra']);
        });

        // 4. ลบคอลัมน์จาก product_parts
        Schema::table('product_parts', function (Blueprint $table) {
            $table->dropColumn(['image_url', 'price_extra', 'is_default']);
        });

        // 3. ลบคอลัมน์จาก product_price
        Schema::table('product_price', function (Blueprint $table) {
            // ถ้าสร้าง Foreign Key ไว้ ต้องลบ FK ก่อนลบคอลัมน์
            // $table->dropForeign(['product_size_id']); 
            
            $table->dropColumn(['product_size_id']);
        });

        // 2. ลบคอลัมน์จาก product_images
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn(['is_main', 'sort_order']);
        });

        // 1. ลบคอลัมน์จาก products
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['moq', 'packing', 'production_time', 'special_features']);
        });
    }
};