<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    use HasFactory;

    protected $table = 'danh_gias';
    protected $primaryKey = 'Ma_DG';

    protected $fillable = [
        'Ma_DT',
        'Ma_Xe',
        'Ma_KT',
        'So_Sao',
        'Noi_Dung',
        'Trang_Thai'
    ];

    
    public function xe()
    {
        return $this->belongsTo(Xe::class, 'Ma_Xe', 'Ma_Xe');
    }

   
    public function khachThue()
    {
        return $this->belongsTo(KhachThue::class, 'Ma_KT', 'Ma_KT');
    }

    
    public function donThue()
    {
        return $this->belongsTo(DonThue::class, 'Ma_DT', 'Ma_DT');
    }
}
