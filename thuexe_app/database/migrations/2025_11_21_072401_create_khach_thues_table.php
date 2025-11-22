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
        Schema::create('khach_thues', function (Blueprint $table) {
            $table->id('Ma_KT');
            $table->string('Ten_KT');
            $table->string('SoDT_KT'); // Đã sửa từ SoDT_CX trong ảnh thành KT cho đúng logic
            $table->string('DiaChi_KT');
            $table->string('Email_KT')->unique();
            $table->string('MatKhau_KT');
            $table->string('CCCD_KT');
            $table->string('GiayPhepLaiXe')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khach_thues');
    }
};
