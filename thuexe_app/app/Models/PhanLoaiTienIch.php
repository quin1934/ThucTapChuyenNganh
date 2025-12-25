<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhanLoaiTienIch extends Model
{
    protected $table = 'phan_loai_tien_iches';
    protected $primaryKey = 'Ma_PLTI';
    protected $fillable = ['Ma_Xe', 'Ma_TI'];
}
