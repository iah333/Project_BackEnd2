<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('don_hang', function (Blueprint $table) {
            $table->increments('ma_don_hang');
            $table->unsignedBigInteger('id');
            $table->timestamp('ngay_dat');
            $table->decimal('tong_tien', 10, 2);
            $table->string('trang_thai')->default('Chờ xử lý');
            $table->timestamps();

            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('don_hang');
    }
};
