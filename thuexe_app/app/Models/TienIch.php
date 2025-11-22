<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TienIch extends Model
{
    protected $table = 'tien_iches';
    protected $primaryKey = 'Ma_TI';
    protected $fillable = ['Ten_TI', 'MoTa_TI'];

    public function xes()
    {
        return $this->belongsToMany(Xe::class, 'phan_loai_tien_iches', 'Ma_TI', 'Ma_Xe');
    }
}