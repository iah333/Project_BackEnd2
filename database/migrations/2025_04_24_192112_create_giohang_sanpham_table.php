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
            $table->unsignedBigInteger('giohang_id');
            $table->unsignedBigInteger('sanpham_id');
            $table->integer('so_luong')->default(1);

            $table->primary(['giohang_id', 'sanpham_id']);

            $table->foreign('giohang_id')->references('id')->on('giohang')->onDelete('cascade');
            $table->foreign('sanpham_id')->references('id')->on('sanpham')->onDelete('cascade');
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
