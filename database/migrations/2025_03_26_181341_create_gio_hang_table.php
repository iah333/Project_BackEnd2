<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gio_hang', function (Blueprint $table) {
            $table->increments('ma_gio_hang');
            $table->unsignedInteger('ma_tai_khoan');
            $table->unsignedInteger('ma_san_pham');
            $table->integer('so_luong');
            $table->foreign('ma_tai_khoan')->references('ma_tai_khoan')->on('tai_khoan')->onDelete('cascade');
            $table->foreign('ma_san_pham')->references('ma_san_pham')->on('san_pham')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gio_hang');
    }
};
