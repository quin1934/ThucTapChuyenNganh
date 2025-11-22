<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    protected $table = 'danh_gias';
    protected $primaryKey = 'Ma_DG';
    protected $fillable = ['Ma_Don', 'Ma_KT', 'DiemSo', 'NoiDung', 'NgayTao'];

    public function donThue()
    {
        return $this->belongsTo(DonThue::class, 'Ma_Don', 'Ma_Don');
    }

    public function khachThue()
    {
        return $this->belongsTo(KhachThue::class, 'Ma_KT', 'Ma_KT');
    }
}