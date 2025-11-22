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
        Schema::create('phan_loai_tien_iches', function (Blueprint $table) {
            $table->id('Ma_PLTI');
            $table->unsignedBigInteger('Ma_Xe');
            $table->unsignedBigInteger('Ma_TI');
            
            $table->foreign('Ma_Xe')->references('Ma_Xe')->on('xes')->onDelete('cascade');
            $table->foreign('Ma_TI')->references('Ma_TI')->on('tien_iches')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phan_loai_tien_iches');
    }
};
