<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongSoKyThuat extends Model
{
    protected $table = 'thong_so_ky_thuats';
    protected $primaryKey = 'Ma_TSKT';

    protected $fillable = [
        'Ma_Xe',
        'Ma_LHS',      
        'Ma_LNL',      
        'Cong_Xuat',
        'MucTieuThu'
    ];

    public function hopSo()
    {
        return $this->belongsTo(DanhMucThongSo::class, 'Ma_LHS', 'Ma_DM');
    }

    public function nhienLieu()
    {
        return $this->belongsTo(DanhMucThongSo::class, 'Ma_LNL', 'Ma_DM');
    }
}
