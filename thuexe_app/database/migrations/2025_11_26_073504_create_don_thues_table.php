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
            $table->id('Ma_DT');
            $table->unsignedBigInteger('Ma_KT'); 
            $table->unsignedBigInteger('Ma_Xe'); 
            $table->dateTime('Ngay_Bat_Dau');       
            $table->dateTime('Ngay_Ket_Thuc');      
            $table->string('Dia_Diem_Nhan')->nullable(); 
            $table->decimal('Gia_Thue_Ngay', 15, 2);
            $table->decimal('Tong_Tien', 15, 2);     
            $table->decimal('Tien_Coc', 15, 2);      
            $table->string('Trang_Thai')->default('ChoDuyet'); 
            $table->text('Ghi_Chu')->nullable();      
            $table->text('Ly_Do_Huy')->nullable();    
            $table->timestamps();
            $table->foreign('Ma_KT')->references('Ma_KT')->on('khach_thues')->onDelete('cascade');
            $table->foreign('Ma_Xe')->references('Ma_Xe')->on('xes')->onDelete('cascade');
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
