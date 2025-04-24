<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('don_hang', function (Blueprint $table) {
            $table->foreign('ma_tai_khoan')->references('ma_tai_khoan')->on('tai_khoan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('don_hang', function (Blueprint $table) {
            $table->dropForeign(['ma_tai_khoan']);
        });
    }
};
