<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donhang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('ten_nguoi_nhan')->nullable();
            $table->string('so_dien_thoai')->nullable();
            $table->dateTime('ngay_dat');
            $table->decimal('tong_tien', 10, 2);
            $table->string('trang_thai')->default('chờ xử lý');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donhang');
    }

};
