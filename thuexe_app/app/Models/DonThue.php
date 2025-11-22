<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonThue extends Model
{
    protected $table = 'don_thues';
    protected $primaryKey = 'Ma_Don';
    protected $fillable = ['Ma_KT', 'Ma_Xe', 'NgayBD', 'NgayKT', 'TongTien', 'TrangThai_Don'];

    public function khachThue()
    {
        return $this->belongsTo(KhachThue::class, 'Ma_KT', 'Ma_KT');
    }

    public function xe()
    {
        return $this->belongsTo(Xe::class, 'Ma_Xe', 'Ma_Xe');
    }

    public function thanhToan()
    {
        return $this->hasOne(ThanhToan::class, 'Ma_Don', 'Ma_Don');
    }

    public function danhGia()
    {
        return $this->hasOne(DanhGia::class, 'Ma_Don', 'Ma_Don');
    }
}