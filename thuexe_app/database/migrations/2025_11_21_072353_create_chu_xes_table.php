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
        Schema::create('chu_xes', function (Blueprint $table) {
            $table->id('Ma_CX');
            $table->string('Ten_CX');
            $table->string('SoDT_CX');
            $table->string('DiaChi_CX');
            $table->string('Email_CX')->unique();
            $table->string('MatKhau_CX');
            $table->string('SoKTNH_CX')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chu_xes');
    }
};
