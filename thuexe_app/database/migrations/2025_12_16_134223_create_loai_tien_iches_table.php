<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('loai_tien_iches')) {
            Schema::create('loai_tien_iches', function (Blueprint $table) {
                $table->id('Ma_LTI'); 
                $table->string('Ten_LTI'); 
                $table->text('MoTa_LTI')->nullable();
                $table->timestamps();
            });
        }
        if (Schema::hasTable('tien_iches')) {
            Schema::table('tien_iches', function (Blueprint $table) {
                
                if (!Schema::hasColumn('tien_iches', 'Ma_LTI')) {
                    $table->unsignedBigInteger('Ma_LTI')->nullable()->after('Ten_TI');
                }
               $table->foreign('Ma_LTI')
                      ->references('Ma_LTI')->on('loai_tien_iches')
                      ->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tien_iches')) {
            Schema::table('tien_iches', function (Blueprint $table) {
                $table->dropForeign(['Ma_LTI']); 
                $table->dropColumn('Ma_LTI');
            });
        }
        
        Schema::dropIfExists('loai_tien_iches');
    }
};