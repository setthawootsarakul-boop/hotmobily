<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable()->index(); // สำหรับ Guest (เก็บ Cookie ID)
            $table->unsignedBigInteger('user_id')->nullable()->index(); // สำหรับสมาชิก
            $table->unsignedBigInteger('product_id');
            
            // เก็บรายละเอียด options เป็น JSON (เช่น size_id, printing_id, parts, text_input)
            $table->json('options')->nullable(); 
            
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};
