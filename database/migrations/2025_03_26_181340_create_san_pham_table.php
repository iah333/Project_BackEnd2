<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sanpham', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('danhmuc_id');
            $table->string('ten_san_pham');
            $table->decimal('gia', 15, 2);
            $table->integer('so_luong_ton');
            $table->string('anh')->nullable();
            $table->timestamps();

            $table->foreign('danhmuc_id')->references('id')->on('danhmuc')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sanpham');
    }
};
