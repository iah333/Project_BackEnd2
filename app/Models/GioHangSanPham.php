<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GioHangSanPham extends Model
{
    protected $table = 'giohang_sanpham';
    protected $primaryKey = ['giohang_id', 'sanpham_id'];
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['giohang_id', 'sanpham_id', 'so_luong'];
    public function gioHang()
    {
        return $this->belongsTo(GioHang::class, 'giohang_id');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'sanpham_id');
    }
}
