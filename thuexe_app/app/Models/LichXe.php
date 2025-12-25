<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichXe extends Model
{
    protected $table = 'lich_xes';
    protected $primaryKey = 'Ma_Lich';
    protected $fillable = ['Ma_Xe', 'Ngay_Bat_Dau', 'Ngay_Ket_Thuc', 'Trang_Thai', 'Ghi_Chu'];

    public function xe()
    {
        return $this->belongsTo(Xe::class, 'Ma_Xe', 'Ma_Xe');
    }
}
