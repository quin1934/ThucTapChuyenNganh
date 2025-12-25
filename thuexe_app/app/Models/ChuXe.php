<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class ChuXe extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'chu_xes';
    protected $primaryKey = 'Ma_CX';

    protected $fillable = [
        'Ten_CX',
        'HinhAnh', 
        'SoDT_CX',
        'DiaChi_CX',
        'Email_CX',
        'SoTKNH_CX',
        'password',
        'Trang_Thai'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function xes()
    {
        return $this->hasMany(Xe::class, 'Ma_CX', 'Ma_CX');
    }
}
