<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chu_xes', function (Blueprint $table) {
            $table->string('HinhAnh')->nullable()->after('Email_CX'); 
        });

        Schema::table('khach_thues', function (Blueprint $table) {
            $table->string('HinhAnh')->nullable()->after('Email_KT');
        });

        Schema::table('xes', function (Blueprint $table) {
            $table->string('HinhAnh')->nullable()->after('Ten_Xe');
        });

        Schema::dropIfExists('hinh_anhs');
    }

    public function down(): void
    {
        Schema::create('hinh_anhs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::table('chu_xes', function (Blueprint $table) { $table->dropColumn('HinhAnh'); });
        Schema::table('khach_thues', function (Blueprint $table) { $table->dropColumn('HinhAnh'); });
        Schema::table('xes', function (Blueprint $table) { $table->dropColumn('HinhAnh'); });
    }
};