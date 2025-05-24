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
            $table->unsignedBigInteger('dia_chi_id')->nullable(); // Thêm cột địa chỉ nếu cần
            $table->string('ten_nguoi_nhan')->nullable();
            $table->string('so_dien_thoai')->nullable();
            $table->dateTime('ngay_dat');
            $table->decimal('tong_tien', 15, 2);
            $table->string('trang_thai')->default('chờ xử lý'); // Trạng thái xử lý đơn hàng
            $table->string('trang_thai_thanh_toan')->default('chưa thanh toán'); // Trạng thái thanh toán
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donhang');
    }
};