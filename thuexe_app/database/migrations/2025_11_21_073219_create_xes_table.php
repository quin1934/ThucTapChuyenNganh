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
        Schema::create('xes', function (Blueprint $table) {
            $table->id('Ma_Xe');
            
            // Khóa ngoại
            $table->unsignedBigInteger('Ma_CX');
            $table->unsignedBigInteger('Ma_PLXe');
            
            // Liên kết khóa ngoại
            $table->foreign('Ma_CX')->references('Ma_CX')->on('chu_xes')->onDelete('cascade');
            $table->foreign('Ma_PLXe')->references('Ma_PLXe')->on('phan_loai_xes');

            $table->string('BienSo')->unique();
            $table->string('Ten_Xe'); // Trong ảnh là Ten_Xe hoặc MoTa_Xe (tôi thêm Ten_Xe cho rõ)
            $table->string('TrangThai_Xe');
            $table->text('MoTa_Xe')->nullable();
            $table->integer('SoGhe');
            $table->integer('NamSX');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xes');
    }
};
