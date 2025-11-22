<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    protected $table = 'thanh_toans';
    protected $primaryKey = 'Ma_TT';
    protected $fillable = ['Ma_Don', 'SoTien', 'Ngay_TT', 'PhuongThuc_TT', 'TrangThai_TT'];

    public function donThue()
    {
        return $this->belongsTo(DonThue::class, 'Ma_Don', 'Ma_Don');
    }
}