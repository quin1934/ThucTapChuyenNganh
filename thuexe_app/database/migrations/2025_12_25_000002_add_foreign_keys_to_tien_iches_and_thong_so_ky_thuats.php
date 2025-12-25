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
        Schema::table('tien_iches', function (Blueprint $table) {
            $table->index('Ma_LTI');
            $table
                ->foreign('Ma_LTI')
                ->references('Ma_LTI')
                ->on('loai_tien_iches')
                ->nullOnDelete();
        });

        Schema::table('thong_so_ky_thuats', function (Blueprint $table) {
            $table->index('Ma_LHS');
            $table->index('Ma_LNL');

            $table
                ->foreign('Ma_LHS')
                ->references('Ma_DM')
                ->on('danh_muc_thong_sos')
                ->nullOnDelete();

            $table
                ->foreign('Ma_LNL')
                ->references('Ma_DM')
                ->on('danh_muc_thong_sos')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thong_so_ky_thuats', function (Blueprint $table) {
            $table->dropForeign(['Ma_LHS']);
            $table->dropForeign(['Ma_LNL']);
            $table->dropIndex(['Ma_LHS']);
            $table->dropIndex(['Ma_LNL']);
        });

        Schema::table('tien_iches', function (Blueprint $table) {
            $table->dropForeign(['Ma_LTI']);
            $table->dropIndex(['Ma_LTI']);
        });
    }
};
