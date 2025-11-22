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
        Schema::create('thanh_toans', function (Blueprint $table) {
            $table->id('Ma_TT');
            $table->unsignedBigInteger('Ma_Don');
            $table->foreign('Ma_Don')->references('Ma_Don')->on('don_thues')->onDelete('cascade');
            
            $table->decimal('SoTien', 15, 2);
            $table->dateTime('Ngay_TT');
            $table->string('PhuongThuc_TT');
            $table->string('TrangThai_TT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thanh_toans');
    }
};
