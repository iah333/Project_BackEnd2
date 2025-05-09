<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'san_pham';
    protected $primaryKey = 'ma_san_pham';
    public $timestamps = true;

    protected $fillable = ['ma_danh_muc', 'ten_san_pham', 'gia', 'so_luong_ton', 'anh'];

    // Mối quan hệ: Một sản phẩm thuộc về một danh mục
    public function danhMuc()
    {
        return $this->belongsTo(DanhMucSanPham::class, 'ma_danh_muc', 'ma_danh_muc');
    }
}