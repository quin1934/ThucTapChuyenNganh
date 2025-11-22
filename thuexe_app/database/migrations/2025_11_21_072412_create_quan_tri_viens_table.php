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
        Schema::create('quan_tri_viens', function (Blueprint $table) {
            $table->id('Ma_QTV');
            $table->string('Ten_QTV');
            $table->string('Email_QTV')->unique();
            $table->string('MatKhau_QTV');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quan_tri_viens');
    }
};
