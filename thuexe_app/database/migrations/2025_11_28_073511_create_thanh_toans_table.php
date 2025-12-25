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
            $table->unsignedBigInteger('Ma_DT');
            $table->decimal('So_Tien', 15, 0);
            $table->dateTime('Ngay_Thanh_Toan')->useCurrent();
            $table->string('Phuong_Thuc')->default('TienMat');
            $table->string('Loai_Thanh_Toan')->default('ThanhToan');
            $table->string('TrangThai_TT')->default('DaThanhToan');
            $table->string('Ma_Giao_Dich')->nullable();
            $table->string('Hinh_Anh_Bill')->nullable();
            $table->text('Ghi_Chu')->nullable();
            $table->timestamps();
            $table->foreign('Ma_DT')->references('Ma_DT')->on('don_thues')->onDelete('cascade');
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
