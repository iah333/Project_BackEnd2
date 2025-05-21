<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('quan_huyen', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('thanh_pho_id');
    $table->string('ten_quan_huyen');
    $table->timestamps();

    $table->foreign('thanh_pho_id')->references('id')->on('thanh_pho')->onDelete('cascade');
      });
    }

    public function down(): void
    {
        Schema::dropIfExists('quan_huyen');
    }
};