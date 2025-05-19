<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuanHuyen extends Model
{
    protected $table = 'quan_huyen';
    protected $fillable = ['thanh_pho_id', 'ten_quan_huyen'];

    public function thanhPho()
    {
        return $this->belongsTo(ThanhPho::class, 'thanh_pho_id');
    }

    public function phuongXas()
    {
        return $this->hasMany(PhuongXa::class, 'quan_huyen_id');
    }
}