<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiTienIch extends Model
{
    use HasFactory;
    protected $table = 'loai_tien_iches';
    protected $primaryKey = 'Ma_LTI';
    protected $fillable = ['Ten_LTI', 'MoTa_LTI'];

    // 1 Loại có nhiều Tiện ích
    public function tienIches()
    {
        return $this->hasMany(TienIch::class, 'Ma_LTI', 'Ma_LTI');
    }
}
