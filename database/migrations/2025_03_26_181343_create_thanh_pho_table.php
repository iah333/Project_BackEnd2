<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thanh_pho', function (Blueprint $table) {
    $table->id();
    $table->string('ten_thanh_pho');
    $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('thanh_pho');
    }
};