<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaChi extends Model
{
    protected $table = 'diachi';
    protected $fillable = ['user_id', 'thanh_pho_id', 'quan_huyen_id', 'phuong_xa_id', 'dia_chi_chi_tiet', 'so_dien_thoai'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thanhPho()
    {
        return $this->belongsTo(ThanhPho::class, 'thanh_pho_id');
    }

    public function quanHuyen()
    {
        return $this->belongsTo(QuanHuyen::class, 'quan_huyen_id');
    }

    public function phuongXa()
    {
        return $this->belongsTo(PhuongXa::class, 'phuong_xa_id');
    }
}