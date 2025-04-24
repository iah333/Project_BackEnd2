<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tai_khoan', function (Blueprint $table) {
            $table->increments('ma_tai_khoan');
            $table->string('ho_ten', 255);
            $table->string('email', 255)->unique();
            $table->string('mat_khau', 255);
            $table->string('so_dien_thoai', 15)->nullable();
            $table->string('vai_tro');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tai_khoan');
    }
};
