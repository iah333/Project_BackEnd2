<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('danh_muc_san_pham', function (Blueprint $table) {
            $table->increments('ma_danh_muc');
            $table->string('ten_danh_muc', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danh_muc_san_pham');
    }
};
