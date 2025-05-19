<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('chitietdonhang', function (Blueprint $table) {
            $table->unsignedBigInteger('donhang_id');
            $table->unsignedBigInteger('sanpham_id');
            $table->integer('so_luong');
            $table->decimal('gia', 10, 2);

            $table->primary(['donhang_id', 'sanpham_id']);

            $table->foreign('donhang_id')->references('id')->on('donhang')->onDelete('cascade');
            $table->foreign('sanpham_id')->references('id')->on('sanpham')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chitietdonhang');
    }
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
};
