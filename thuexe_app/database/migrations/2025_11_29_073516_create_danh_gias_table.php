<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('danh_gias', function (Blueprint $table) {
            $table->id('Ma_DG');
            $table->unsignedBigInteger('Ma_DT')->unique(); 
            $table->unsignedBigInteger('Ma_Xe'); 
            $table->unsignedBigInteger('Ma_KT'); 
            $table->integer('So_Sao')->default(5);
            $table->text('Noi_Dung')->nullable();
            $table->string('Trang_Thai')->default('HienThi');
            $table->timestamps();
            $table->foreign('Ma_DT')->references('Ma_DT')->on('don_thues')->onDelete('cascade');
            $table->foreign('Ma_Xe')->references('Ma_Xe')->on('xes')->onDelete('cascade');
            $table->foreign('Ma_KT')->references('Ma_KT')->on('khach_thues')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danh_gias');
    }
};
