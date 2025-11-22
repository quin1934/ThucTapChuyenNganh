<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('thong_so_ky_thuats', function (Blueprint $table) {
            $table->id('Ma_TSKT');
            $table->unsignedBigInteger('Ma_Xe'); // Quan hệ 1-1 với Xe
            $table->foreign('Ma_Xe')->references('Ma_Xe')->on('xes')->onDelete('cascade');
            
            $table->string('LoaiHopSo');
            $table->string('LoaiNhienLieu');
            $table->string('Cong_Xuat')->nullable();
            $table->string('MucTieuThu')->nullable();
            // Lưu ý: Trong ảnh bạn có cột Ma_PLXe ở đây, nhưng thường thông số kỹ thuật gắn thẳng vào Xe là đủ.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thong_so_ky_thuats');
    }
};
