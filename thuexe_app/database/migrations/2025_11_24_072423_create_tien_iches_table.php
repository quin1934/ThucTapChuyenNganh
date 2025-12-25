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
        Schema::create('tien_iches', function (Blueprint $table) {
            $table->id('Ma_TI');
            $table->string('Ten_TI');
            $table->string('Loai_TI')->nullable()->default('Khac');
            $table->text('MoTa_TI')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tien_iches');
    }
};
