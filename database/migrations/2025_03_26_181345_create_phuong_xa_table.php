<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('phuong_xa', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('quan_huyen_id');
    $table->string('ten_phuong_xa');
    $table->timestamps();

    $table->foreign('quan_huyen_id')->references('id')->on('quan_huyen')->onDelete('cascade');
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('phuong_xa');
    }
};