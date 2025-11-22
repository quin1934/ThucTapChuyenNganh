<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanLoaiXe extends Model
{
    use HasFactory;
    protected $table = 'phan_loai_xes';
    protected $primaryKey = 'Ma_PLXe';
    protected $fillable = ['Ten_PLXe', 'MoTa_PLXe'];
    public function xes()
    {
        return $this->hasMany(Xe::class, 'Ma_PLXe', 'Ma_PLXe');
    }
}