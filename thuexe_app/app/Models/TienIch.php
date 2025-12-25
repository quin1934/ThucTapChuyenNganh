<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TienIch extends Model
{
    use HasFactory;
    protected $table = 'tien_iches';
    protected $primaryKey = 'Ma_TI';
    protected $fillable = ['Ten_TI', 'MoTa_TI', 'Ma_LTI'];

    public function loaiTienIch()
    {
        return $this->belongsTo(LoaiTienIch::class, 'Ma_LTI', 'Ma_LTI');
    }

    public function xes()
    {
        return $this->belongsToMany(Xe::class, 'phan_loai_tien_iches', 'Ma_TI', 'Ma_Xe');
    }
}
