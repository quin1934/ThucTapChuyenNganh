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
        Schema::create('don_thues', function (Blueprint $table) {
            $table->id('Ma_Don');
            
            $table->unsignedBigInteger('Ma_KT');
            $table->unsignedBigInteger('Ma_Xe');
            
            $table->foreign('Ma_KT')->references('Ma_KT')->on('khach_thues');
            $table->foreign('Ma_Xe')->references('Ma_Xe')->on('xes');
            
            $table->dateTime('NgayBD');
            $table->dateTime('NgayKT');
            $table->string('TrangThai_Don');
            $table->decimal('TongTien', 15, 2);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('don_thues');
    }
};
