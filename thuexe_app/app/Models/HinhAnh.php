<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HinhAnh extends Model
{
    protected $table = 'hinh_anhs';
    protected $primaryKey = 'Ma_HA';
    protected $fillable = ['Ma_Xe', 'Url_HinhAnh', 'NgayTaiLen'];

    public function xe()
    {
        return $this->belongsTo(Xe::class, 'Ma_Xe', 'Ma_Xe');
    }
}