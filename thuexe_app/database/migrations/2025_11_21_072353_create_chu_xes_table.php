<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chu_xes', function (Blueprint $table) {
            $table->id('Ma_CX');
            $table->string('Ten_CX'); 
            $table->string('SoDT_CX')->unique(); 
            $table->string('Email_CX')->nullable();
            $table->string('DiaChi_CX')->nullable();
            $table->string('SoTKNH_CX')->nullable(); 
            $table->string('password');        
            $table->string('HinhAnh')->nullable(); 
            $table->string('Trang_Thai')->default('ChoDuyet');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chu_xes');
    }
};
