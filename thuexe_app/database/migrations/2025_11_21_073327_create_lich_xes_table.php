<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('lich_xes', function (Blueprint $table) 
    {   
        $table->id('Ma_Lich');  
        $table->unsignedBigInteger('Ma_Xe');
        $table->dateTime('Ngay');
        $table->string('TrangThaiNgay');               
        $table->foreign('Ma_Xe')->references('Ma_Xe')->on('xes')->onDelete('cascade');      
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_xes');
    }
};
