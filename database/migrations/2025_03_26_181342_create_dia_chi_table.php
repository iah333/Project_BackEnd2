<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dia_chi', function (Blueprint $table) {
            $table->id('ma_dia_chi');
            $table->unsignedBigInteger('id'); // FK to users
            $table->string('dia_chi');
            $table->string('thanh_pho');
            $table->string('so_dien_thoai');
            $table->timestamps();

            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dia_chi');
    }
};