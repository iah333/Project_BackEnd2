<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhuongXa extends Model
{
    protected $table = 'phuong_xa';
    protected $fillable = ['quan_huyen_id', 'ten_phuong_xa'];

    public function quanHuyen()
    {
        return $this->belongsTo(QuanHuyen::class, 'quan_huyen_id');
    }
}