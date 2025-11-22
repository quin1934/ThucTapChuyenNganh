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
    Schema::create('danh_gias', function (Blueprint $table) {
        $table->id('Ma_DG');
        $table->unsignedBigInteger('Ma_Don');
        $table->unsignedBigInteger('Ma_KT');
        $table->integer('DiemSo');
        $table->text('NoiDung')->nullable();
        $table->dateTime('NgayTao')->useCurrent();       
        $table->timestamps();
        $table->foreign('Ma_Don')->references('Ma_Don')->on('don_thues')->onDelete('cascade');
        $table->foreign('Ma_KT')->references('Ma_KT')->on('khach_thues')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_gias');
    }
};
