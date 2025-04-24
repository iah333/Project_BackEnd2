<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('don_hang', function (Blueprint $table) {
            $table->increments('ma_don_hang');
            $table->unsignedInteger('ma_tai_khoan');
            $table->timestamp('ngay_dat')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->decimal('tong_tien', 10, 2);
            $table->string('trang_thai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('don_hang');
    }
};