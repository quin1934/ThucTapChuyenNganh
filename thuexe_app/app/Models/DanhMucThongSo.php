<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMucThongSo extends Model
{
    use HasFactory;
    protected $table = 'danh_muc_thong_sos';
    protected $primaryKey = 'Ma_DM';
    protected $fillable = ['Ten_DM', 'Loai_DanhMuc', 'MoTa_DM'];

   
    public function scopeNhienLieu($query)
    {
        return $query->where('Loai_DanhMuc', 'NhienLieu');
    }

    public function scopeHopSo($query)
    {
        return $query->where('Loai_DanhMuc', 'HopSo');
    }

    public function xeSuDungNhienLieu()
    {       
        return $this->hasMany(ThongSoKyThuat::class, 'Ma_LNL', 'Ma_DM');
    }

    public function xeSuDungHopSo()
    {
        return $this->hasMany(ThongSoKyThuat::class, 'Ma_LHS', 'Ma_DM');
    }
}
