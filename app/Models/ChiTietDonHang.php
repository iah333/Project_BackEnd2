<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    protected $table = 'chitietdonhang';

    protected $fillable = [
        'donhang_id',
        'sanpham_id',
        'so_luong',
        'gia',
    ];

    public $timestamps = false;

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'donhang_id');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'sanpham_id');
    }
}
