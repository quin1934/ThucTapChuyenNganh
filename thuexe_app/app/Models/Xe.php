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
        'Ma_CX', 'Ma_PLXe', 'BienSo', 'Ten_Xe', 
        'TrangThai_Xe', 'MoTa_Xe', 'SoGhe', 'NamSX'
    ];
    public function chuXe()
    {      
        return $this->belongsTo(ChuXe::class, 'Ma_CX', 'Ma_CX');
    }
    public function phanLoaiXe()
    {
        return $this->belongsTo(PhanLoaiXe::class, 'Ma_PLXe', 'Ma_PLXe');
    }
    public function hinhAnhs()
    {
        return $this->hasMany(HinhAnh::class, 'Ma_Xe', 'Ma_Xe');
    }
    public function thongSo()
    {
        return $this->hasOne(ThongSoKyThuat::class, 'Ma_Xe', 'Ma_Xe');
    }
}