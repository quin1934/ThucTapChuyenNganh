<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonThue extends Model
{
    use HasFactory;

    protected $table = 'don_thues';
    protected $primaryKey = 'Ma_DT';

    protected $fillable = [
        'Ma_KT', 
        'Ma_Xe', 
        'Ngay_Bat_Dau', 
        'Ngay_Ket_Thuc', 
        'Dia_Diem_Nhan', 
        'Gia_Thue_Ngay', 
        'Tong_Tien', 
        'Tien_Coc', 
        'Trang_Thai', 
        'Ghi_Chu', 
        'Ly_Do_Huy'
    ];

    
    public function khachThue()
    {
        return $this->belongsTo(KhachThue::class, 'Ma_KT', 'Ma_KT');
    }

    
    public function xe()
    {
        return $this->belongsTo(Xe::class, 'Ma_Xe', 'Ma_Xe');
    }
    
   
    public function thanhToans()
    {
        return $this->hasMany(ThanhToan::class, 'Ma_DT', 'Ma_DT');
    }
}
