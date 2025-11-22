<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongSoKyThuat extends Model
{
    protected $table = 'thong_so_ky_thuats';
    protected $primaryKey = 'Ma_TSKT';
    protected $fillable = ['Ma_Xe', 'LoaiHopSo', 'LoaiNhienLieu', 'Cong_Xuat', 'MucTieuThu'];

    public function xe()
    {
        return $this->belongsTo(Xe::class, 'Ma_Xe', 'Ma_Xe');
    }
}