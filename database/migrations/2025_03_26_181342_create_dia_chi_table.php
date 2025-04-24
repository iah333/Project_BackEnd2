<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dia_chi', function (Blueprint $table) {
            $table->increments('ma_dia_chi');
            $table->unsignedInteger('ma_tai_khoan');
            $table->text('dia_chi');
            $table->string('thanh_pho', 255);
            $table->string('so_dien_thoai', 15)->nullable();
            $table->foreign('ma_tai_khoan')->references('ma_tai_khoan')->on('tai_khoan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dia_chi');
    }
};