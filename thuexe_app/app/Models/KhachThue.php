<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhachThue extends Model
{
    protected $table = 'khach_thues';
    protected $primaryKey = 'Ma_KT'; 
    protected $fillable = ['Ten_KT', 'SoDT_KT', 'DiaChi_KT', 'Email_KT', 'MatKhau_KT', 'CCCD_KT', 'GiayPhepLaiXe'];

    public function donThues()
    {
        return $this->hasMany(DonThue::class, 'Ma_KT', 'Ma_KT');
    }

    public function danhGias()
    {
        return $this->hasMany(DanhGia::class, 'Ma_KT', 'Ma_KT');
    }
    
    public function lichSuTimKiems()
    {
        return $this->hasMany(LichSuTimKiem::class, 'Ma_KT', 'Ma_KT');
    }
}