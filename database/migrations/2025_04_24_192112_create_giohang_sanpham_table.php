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
        Schema::create('giohang_sanpham', function (Blueprint $table) {
            $table->unsignedInteger('ma_gio_hang');
            $table->unsignedInteger('ma_san_pham');
            $table->integer('so_luong')->default(1);

            $table->primary(['ma_gio_hang', 'ma_san_pham']);
            $table->foreign('ma_gio_hang')->references('ma_gio_hang')->on('gio_hang')->onDelete('cascade');
            $table->foreign('ma_san_pham')->references('ma_san_pham')->on('san_pham')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giohang_sanpham');
    }
};
