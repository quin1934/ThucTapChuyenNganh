<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // sessions.user_id -> users.id
        Schema::table('sessions', function (Blueprint $table) {
            if (Schema::hasColumn('sessions', 'user_id')) {
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            }
        });

        // promotions.ma_xe -> xes.Ma_Xe
        // promotions.ma_plxe -> phan_loai_xes.Ma_PLXe
        // promotions.created_by -> users.id
        Schema::table('promotions', function (Blueprint $table) {
            if (Schema::hasColumn('promotions', 'ma_xe')) {
                $table->foreign('ma_xe')
                    ->references('Ma_Xe')
                    ->on('xes')
                    ->nullOnDelete();
            }

            if (Schema::hasColumn('promotions', 'ma_plxe')) {
                $table->foreign('ma_plxe')
                    ->references('Ma_PLXe')
                    ->on('phan_loai_xes')
                    ->nullOnDelete();
            }

            if (Schema::hasColumn('promotions', 'created_by')) {
                $table->foreign('created_by')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            }
        });

        // cms_blocks.created_by/updated_by -> users.id
        Schema::table('cms_blocks', function (Blueprint $table) {
            if (Schema::hasColumn('cms_blocks', 'created_by')) {
                $table->foreign('created_by')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            }

            if (Schema::hasColumn('cms_blocks', 'updated_by')) {
                $table->foreign('updated_by')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->dropForeign(['ma_xe']);
            $table->dropForeign(['ma_plxe']);
            $table->dropForeign(['created_by']);
        });

        Schema::table('cms_blocks', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
    }
};
