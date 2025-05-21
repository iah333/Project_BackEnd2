<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donhang', function (Blueprint $table) {
            $table->unsignedBigInteger('dia_chi_id')->nullable()->after('user_id');
            $table->foreign('dia_chi_id')->references('id')->on('diachi')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('donhang', function (Blueprint $table) {
            $table->dropForeign(['dia_chi_id']);
            $table->dropColumn('dia_chi_id');
        });
    }
};