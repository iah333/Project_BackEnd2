<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'sanpham';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['danhmuc_id', 'ten_san_pham', 'gia', 'so_luong_ton', 'anh'];

    // Mối quan hệ: Một sản phẩm thuộc về một danh mục
    public function danhMuc()
    {
        return $this->belongsTo(DanhMucSanPham::class, 'danhmuc_id', 'id');
    }
    public function gioHangs()
    {
        return $this->belongsToMany(GioHang::class, 'giohang_sanpham')
            ->withPivot('so_luong')
            ->withTimestamps();
    }
}
