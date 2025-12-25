<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('danh_muc_thong_sos')) {
            Schema::create('danh_muc_thong_sos', function (Blueprint $table) {
                $table->id('Ma_DM');
                $table->string('Ten_DM');
                $table->string('Loai_DanhMuc');
                $table->text('MoTa_DM')->nullable();
                $table->timestamps();
            });
        }

        if (Schema::hasTable('thong_so_ky_thuats')) {
            Schema::table('thong_so_ky_thuats', function (Blueprint $table) {

                if (Schema::hasColumn('thong_so_ky_thuats', 'LoaiHopSo')) {
                    $table->dropColumn('LoaiHopSo');
                }
                if (Schema::hasColumn('thong_so_ky_thuats', 'LoaiNhienLieu')) {
                    $table->dropColumn('LoaiNhienLieu');
                }
            });

            Schema::table('thong_so_ky_thuats', function (Blueprint $table) {
                if (!Schema::hasColumn('thong_so_ky_thuats', 'LoaiHopSo')) {
                    $table->unsignedBigInteger('LoaiHopSo')->nullable()->after('Ma_Xe');
                    $table->foreign('LoaiHopSo')
                        ->references('Ma_DM')->on('danh_muc_thong_sos')
                        ->onDelete('set null');
                }
                if (!Schema::hasColumn('thong_so_ky_thuats', 'LoaiNhienLieu')) {
                    $table->unsignedBigInteger('LoaiNhienLieu')->nullable()->after('LoaiHopSo');
                    $table->foreign('LoaiNhienLieu')
                        ->references('Ma_DM')->on('danh_muc_thong_sos')
                        ->onDelete('set null');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('thong_so_ky_thuats')) {
            Schema::table('thong_so_ky_thuats', function (Blueprint $table) {
                if (Schema::hasColumn('thong_so_ky_thuats', 'LoaiHopSo')) {
                    $table->dropForeign(['LoaiHopSo']);
                    $table->dropColumn('LoaiHopSo');
                }
                if (Schema::hasColumn('thong_so_ky_thuats', 'LoaiNhienLieu')) {
                    $table->dropForeign(['LoaiNhienLieu']);
                    $table->dropColumn('LoaiNhienLieu');
                }
                $table->string('LoaiHopSo')->nullable();
                $table->string('LoaiNhienLieu')->nullable();
            });
        }

        Schema::dropIfExists('danh_muc_thong_sos');
    }
};
