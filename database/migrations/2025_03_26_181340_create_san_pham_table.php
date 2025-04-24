<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('san_pham', function (Blueprint $table) {
            $table->increments('ma_san_pham');
            $table->unsignedInteger('ma_danh_muc');
            $table->string('ten_san_pham', 255);
            $table->decimal('gia', 10, 2);
            $table->integer('so_luong_ton');
            $table->string('anh', 255)->nullable();
            $table->foreign('ma_danh_muc')->references('ma_danh_muc')->on('danh_muc_san_pham')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('san_pham');
    }
};
