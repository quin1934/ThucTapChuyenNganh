<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichXe extends Model
{
    protected $table = 'lich_xes';
    protected $primaryKey = 'Ma_Lich';
    protected $fillable = ['Ma_Xe', 'Ngay', 'TrangThaiNgay'];

    public function xe()
    {
        return $this->belongsTo(Xe::class, 'Ma_Xe', 'Ma_Xe');
    }
}