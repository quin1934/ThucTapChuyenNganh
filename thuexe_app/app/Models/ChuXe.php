<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChuXe extends Model
{
    use HasFactory;
    protected $table = 'chu_xes';
    protected $primaryKey = 'Ma_CX';
    protected $fillable = [
        'Ten_CX', 'SoDT_CX', 'DiaChi_CX', 'Email_CX', 'MatKhau_CX', 'SoKTNH_CX'
    ];
    public function xes()
    {
        return $this->hasMany(Xe::class, 'Ma_CX', 'Ma_CX');
    }
}