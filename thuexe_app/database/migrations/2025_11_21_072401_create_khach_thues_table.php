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
            $table->string('Ho_Ten');
            $table->string('So_Dien_Thoai')->unique(); 
            $table->string('password')->nullable();    
            $table->string('Email')->nullable();       
            $table->string('CCCD')->nullable();        
            $table->string('Dia_Chi')->nullable();     
            $table->string('So_GPLX')->nullable();          
            $table->string('Hang_Bang_Lai')->nullable();    
            $table->date('Ngay_Cap_GPLX')->nullable();      
            $table->date('Ngay_Het_Han_GPLX')->nullable();  
            $table->string('Anh_Bang_Lai_Truoc')->nullable(); 
            $table->string('Anh_Bang_Lai_Sau')->nullable();   

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