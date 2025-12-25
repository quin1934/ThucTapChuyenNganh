<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    use HasFactory;

    protected $table = 'thanh_toans';
    protected $primaryKey = 'Ma_TT';

    protected $fillable = [
        'Ma_DT', 
        'So_Tien', 
        'Ngay_Thanh_Toan', 
        'Phuong_Thuc', 
        'Loai_Thanh_Toan', 
        'TrangThai_TT', 
        'Ma_Giao_Dich', 
        'Hinh_Anh_Bill', 
        'Ghi_Chu'
    ];

    public function donThue()
    {
        return $this->belongsTo(DonThue::class, 'Ma_DT', 'Ma_DT');
    }
}