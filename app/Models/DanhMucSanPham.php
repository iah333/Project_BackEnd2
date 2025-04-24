<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMucSanPham extends Model
{
    protected $table = 'danh_muc_san_pham';
    protected $primaryKey = 'ma_danh_muc';
    public $timestamps = true;

    protected $fillable = ['ten_danh_muc'];

    // Mối quan hệ: Một danh mục có nhiều sản phẩm
    public function sanPhams()
    {
        return $this->hasMany(SanPham::class, 'ma_danh_muc', 'ma_danh_muc');
    }
    
}