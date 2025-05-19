<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diachi', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('thanh_pho_id');
    $table->unsignedBigInteger('quan_huyen_id');
    $table->unsignedBigInteger('phuong_xa_id');
    $table->string('dia_chi_chi_tiet'); // Trường nhập địa chỉ cụ thể (số nhà, đường,...)
    $table->string('so_dien_thoai');
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('thanh_pho_id')->references('id')->on('thanh_pho')->onDelete('cascade');
    $table->foreign('quan_huyen_id')->references('id')->on('quan_huyen')->onDelete('cascade');
    $table->foreign('phuong_xa_id')->references('id')->on('phuong_xa')->onDelete('cascade');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('diachi');
    }
};