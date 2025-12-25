<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xe extends Model
{
    use HasFactory;

    protected $table = 'xes';
    protected $primaryKey = 'Ma_Xe';
    protected $fillable = [
        'Ma_CX',
        'Ma_PLXe',
        'BienSo',
        'Ten_Xe',
        'HinhAnh',
        'TrangThai_Xe',
        'MoTa_Xe',
        'SoGhe',
        'NamSX',
        'GiaThue'
    ];
    public function chuXe()
    {
        return $this->belongsTo(ChuXe::class, 'Ma_CX', 'Ma_CX');
    }
    public function phanLoaiXe()
    {
        return $this->belongsTo(PhanLoaiXe::class, 'Ma_PLXe', 'Ma_PLXe');
    }  
    public function thongSo()
    {
        return $this->hasOne(ThongSoKyThuat::class, 'Ma_Xe', 'Ma_Xe');
    }
    public function tienIches()
    {
        return $this->belongsToMany(
            TienIch::class,
            'phan_loai_tien_iches',
            'Ma_Xe',
            'Ma_TI'
        )->withTimestamps();
    }
    public function danhGias()
    {
        return $this->hasMany(DanhGia::class, 'Ma_Xe', 'Ma_Xe')->where('Trang_Thai', 'HienThi');
    }

    public function getDiemTrungBinhAttribute()
    {
        return round($this->danhGias()->avg('So_Sao'), 1) ?? 0;
    }

    public function getSoLuongDanhGiaAttribute()
    {
        return $this->danhGias()->count();
    }
}
