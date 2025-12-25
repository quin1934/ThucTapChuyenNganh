<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('thong_so_ky_thuats')) {
            Schema::create('thong_so_ky_thuats', function (Blueprint $table) {
                $table->id('Ma_TSKT');
                $table->unsignedBigInteger('Ma_Xe');
                $table->string('Cong_Xuat')->nullable(); 
                $table->string('MucTieuThu')->nullable();
                $table->string('LoaiHopSo')->nullable(); 
                $table->string('LoaiNhienLieu')->nullable();
                $table->timestamps();
                $table->foreign('Ma_Xe')->references('Ma_Xe')->on('xes')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('thong_so_ky_thuats');
    }
};