<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chi_tiet_don_hang', function (Blueprint $table) {
            $table->increments('ma_chi_tiet');
            $table->unsignedInteger('ma_don_hang');
            $table->unsignedInteger('ma_san_pham');
            $table->integer('so_luong');
            $table->decimal('gia', 10, 2);
            $table->foreign('ma_don_hang')->references('ma_don_hang')->on('don_hang')->onDelete('cascade');
            $table->foreign('ma_san_pham')->references('ma_san_pham')->on('san_pham')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_don_hang');
    }
};