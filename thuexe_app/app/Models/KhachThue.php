<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class KhachThue extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'khach_thues';
    protected $primaryKey = 'Ma_KT';

    protected $fillable = [
        // --- Thông tin cũ ---
        'Ho_Ten',
        'So_Dien_Thoai',
        'CCCD',
        'Dia_Chi',
        'Email',
        'password',

        'HinhAnh',

        
        'So_GPLX',            
        'Hang_Bang_Lai',      
        'Ngay_Cap_GPLX',      
        'Ngay_Het_Han_GPLX',  

        'Anh_Bang_Lai_Truoc',
        'Anh_Bang_Lai_Sau'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function donThues()
    {
        return $this->hasMany(DonThue::class, 'Ma_KT', 'Ma_KT');
    }
}
