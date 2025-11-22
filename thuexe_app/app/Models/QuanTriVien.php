<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class QuanTriVien extends Model
{
    protected $table = 'quan_tri_viens';
    protected $primaryKey = 'Ma_QTV';
    protected $fillable = ['Ten_QTV', 'Email_QTV', 'MatKhau_QTV'];
    
    protected $hidden = ['MatKhau_QTV'];
}